# This file is a help to change Your project from phprechnung to rosine (newest version)
# it is beta, but worked with me own version. You need a coulumn called "POS_EINHEIT" in table rothaar_postion.
# If you have the original phprechnung, please remove the prefix 'rothaar_' from table names!


# Artikel in neue Tabelle
UPDATE `rothaar_position` SET `POS_EINHEIT`="Stück"  WHERE POS_EINHEIT="";
INSERT INTO rosine_articles SELECT POS_NAME, POS_TEXT, POS_EINHEIT, (POS_PREIS/1.19), POS_MWST, POS_LAGER, POS_LAGER_AKTUELL, NOTE, ERSTELLT, GEAENDERT from rothaar_position;

# Angebote in neue Tabelle
INSERT INTO rosine_offers SELECT ANGEBOTID, DATUM, MYID, 0, (ANGEBOT_SUMME/1.19), ANGEBOT_SUMME, "", RECHNUNGID, 0, ERSTELLT, GEAENDERT FROM rothaar_angebot;

UPDATE rosine_offers SET OFFER_CUSTOMER_PRIVATE=1, OFFER_CUSTOMER=(OFFER_CUSTOMER-10000) WHERE OFFER_CUSTOMER>10000;
UPDATE rosine_offers SET OFFER_STATUS = CONCAT("in ", OFFER_STATUS) WHERE OFFER_STATUS !="0";
UPDATE rosine_offers SET OFFER_STATUS ="old" WHERE OFFER_STATUS="0";
INSERT INTO rosine_offers_positions SELECT a.ANGEBOTID, a.ANGEBOTPOSID, p.POS_NAME, a.POS_MENGE, p.POS_EINHEIT, (a.POS_PREIS / 1.19), p.POS_LAGER, a.POS_SERIENNR, a.POS_TEXT, p.POS_MWST, "J" FROM rothaar_angebotpos AS a JOIN rothaar_position AS p ON a.POSITIONID = p.POSITIONID WHERE 1;
# Neue Durchnummerierung hat noch nicht funktioniert

# Rechnungen in neue Tabelle
INSERT INTO rosine_invoices SELECT r.RECHNUNGID, r.DATUM, r.MYID, 0, (r.RE_SUMME / 1.19), r.RE_SUMME, m.MITTEILUNG_TXT, IF( r.BEZAHLT = "J", "paied", r.RE_OFFEN ) , IF( r.GEDRUCKT = "J", "1", "0" ) , r.ERSTELLT, r.GEAENDERT FROM rothaar_rechnung as r join rothaar_mitteilung as m on r.MITTEILUNGTXT=m.MITTEILUNGID;

UPDATE rosine_invoices SET INVOICE_CUSTOMER_PRIVATE=1, INVOICE_CUSTOMER=(INVOICE_CUSTOMER-10000) WHERE INVOICE_CUSTOMER>10000;

INSERT INTO rosine_invoices_positions SELECT r.RECHNUNGID, r.VERKAUFID, p.POS_NAME , r.POS_MENGE, p.POS_EINHEIT, (r.POS_PREIS / 1.19), p.POS_LAGER, r.POS_SERIENNR, r.POS_TEXT, p.POS_MWST, 1 FROM rothaar_verkauf AS r JOIN rothaar_position AS p ON r.POSITIONID = p.POSITIONID WHERE 1;

UPDATE rosine_invoices_positions as p JOIN rosine_invoices as i ON p.INVOICE_ID=i.INVOICE.ID SET p.DONE=0 WHERE  i.INVOICE_STATUS="0.00" 

# Zahlungen einfügen
INSERT INTO rosine_payments  SELECT ZAHLUNGID, RECHNUNGID, DATUM, ZHLGWEISE, ZHLG_SUMME, CONCAT (MYID, " ",ERSTELLT) from rothaar_zahlung
