<?php

/**************************************************************************\
 * Rothaar Systems Open Source Invoice for Egroupware (ROSInE)              *
 * http://www.rothaarsystems.de                                             *
 * Author: info@rothaarsystems.de                                           *
 * --------------------------------------------                             *
 *  This program is free software; you can redistribute it and/or modify it *
 *  under the terms of the GNU General Public License as published by the   *
 *  Free Software Foundation; version 2 of the License.                     *
 *  date of this file: 2017-02-11	    	 								*
 \**************************************************************************/

$lang['page_buttons']='{$backward} {$from} bis {$to} von insgesamt {$max} {$foreward}';
$lang['just_write_invoices']="Rechnungen einfach schreiben!";
// for main menue
$lang['main_menue']="Hauptmenü";
$lang['configurations']="Einstellungen";
$lang['offers']="Angebote";
$lang['make_new_offer']="Neues Angebot erstellen";
$lang['offer_list']="Angebotsliste";
$lang['orders']="Bestellungen";
$lang['input_new_order']="Neue Bestellung eingeben";
$lang['orders_list']="Liste der Bestellungen";
$lang['delivery_notes']="Lieferscheine";
$lang['generate_new_delivery_note']="Neuen Lieferschein anlegen";
$lang['delivery_note_list']="Lieferscheinliste";
$lang['invoices']="Rechnungen";
$lang['generate_new_invoice']="Neue Rechnung anlegen";
$lang['invoice_list']="Rechnungsliste";
$lang['payments']="Zahlungen";
$lang['input_new_payment']="Zahlungseingänge verbuchen";
$lang['unpaid_invoices']="offene Rechnungen";
$lang['dunnings']="Mahnungen";
$lang['articles']="Artikel";
$lang['article']="Artikel";
$lang['taxes']="Steuersätze";
$lang['number']="Nummer";
$lang['stock_locations']="Lagerorte";
$lang['generate_articles']="Artikel erstellen";
$lang['articles_list']="Artikelliste";
// for articles
$lang['insert_new_article']       = "Neuen Artikel einfügen";
$lang['insert_again_new_article'] = "Weiteren Artikel einfügen";
$lang['change_article'] = "Artikel ändern";
$lang['notes'] = "Hinweise";
$lang['back']        = "zurück";
$lang['article_number']="Artikelnummer";
$lang['unity']="Einheit";
$lang['article_name']="Artikelbezeichnung";
$lang['price']="Preis";
$lang['tax']='MwSt';
$lang['stock_location']="Lagerort";
$lang['stock']="Bestand";

// error messages
$lang['number_missing']="Nummer fehlt";
$lang['name_missing']="Name fehlt";

// OK messages
$lang['article_inserted']="Artikel eingefügt";
$lang['article_changed']="Artikel geändert!";
$lang['article_deleted']="Artikel gelöscht";
// for lists
$lang['delete']="löschen";
$lang['change']="ändern";
$lang['really_delete']="wirklich löschen";
$lang['make_new']="neu erstellen";
		
// for taxes
$lang['tax_deleted']="Steuersatz gelöscht";
$lang['tax_id']="Nummer";
$lang['tax_name']="Bezeichnung";
$lang['tax_percentage']="Prozentsatz";
$lang['insert_new_tax']="Neue Steuer einfügen";
$lang['insert_again_new_tax']="Weitere Steuer einfügen";
$lang['tax_changed']="Steuersatz geändert";
$lang['tax_inserted']="Steuersatz eingefügt";
$lang['change_tax']="Steuersatz ändern";

// for locations
$lang['location_deleted']="Lagerort gelöscht";
$lang['location_id']="Lagernummer";
$lang['location_name']="Lagername";
$lang['insert_new_location']="Neuen Lagerort hinzufügen";
$lang['insert_again_new_location']="Weiteren Lagerort einfügen";
$lang['location_changed']="Lagerort geändert";
$lang['location_inserted']="Lagerort eingefügt";
$lang['change_location']="Lagerort ändern";


//for offers / orders etc
$lang['cancel']="Abbrechen";
$lang['next_step']="Weiter";
$lang['what_s_next']="Und jetzt?";
$lang['favorite_articles']="Beliebte Artikel";
$lang['offer']="Angebot";
$lang['order']="Bestellung";
$lang['delivery']="Lieferung";
$lang['invoice']="Rechnung";
$lang['customer']="Kunde";
$lang['insert_into_paperwork']='Artikel in {$paperwork} einfügen';
$lang['change_paperwork']='{$paperwork} ändern';
$lang['paperwork_for_customer']='{$paperwork} für Kunde';
$lang['ammount']="Menge";
$lang['nothing_found']="nichts gefunden";
$lang['paperwork_inserted']='{$paperwork} eingefügt';
$lang['added']=' hinzugefügt!';
$lang['numbers_corrected']="Nummern korrigiert";
$lang['paperwork_positions_deleted']="Artikel in %paperwork% gelöscht ";
$lang['paperwork_deleted']="%paperwork% gelöscht ";
$lang['posi_id']="Position";
$lang['ready']="Fertig";
$lang['print']="drucken";
$lang['print_again']="nochmal drucken";
$lang['offer_number']="Nummer";
$lang['private']="(Privat)";
$lang['company']="(Firma)";
$lang['date']="Datum";
$lang['status']="Status";
$lang['add_articles_from_other_tables']="Artikel aus anderen Tabellen einfügen";
$lang['from_paperwork']='Aus %paperwork%: %ID1%';
$lang['change_item_in_paperwork']='{$paperwork}-Artikel ändern';
$lang['item_text']="Artikeltext";
$lang['position']="Position";
$lang['plus']="zzgl.";
$lang['item_changed']="Position geändert!";
$lang['customer_list']="Kundenliste";
$lang['more_functions']="weitere Funktionen";
$lang['functions']="Funktionen";
$lang['preview']="Vorschau";
$lang['customers_with_most_sales']="Alle Kunden sortiert nach Umsatz (nor working yet!)";
$lang['customers_with_most_paperwork']='Alle Kunden sortiert nach den meisten {$paperwork}';
$lang['sorted_in_alphabetic_order']='Alle Kunden alphabetisch sortiert';
$lang['last_customers']="Die zuletzt verwendeten Kunden";
$lang['customer_name_or_number']="Kundenname oder Nummer";
$lang['choose_invoice_for_payment']="Zahlung eintragen";
$lang['insert_payment']="Zahlung einfügen";
$lang['unpayed_ammount']="unbezahlter Betrag: ";
$lang['from']="von";
$lang['and']="und";
$lang['payment_inserted']="Zahlung eingefügt!";
$lang['payed_money']="Zahlung";
$lang['invoice_payed']="Rechnung ist bezahlt!";
$lang['ammount_due']="Betrag";
$lang['terms']="Bedingungen";
$lang['ammount_netto']="Gesamt (netto)";
$lang['ammount_tax']="MwSt";
$lang['ammount_brutto']="Gesamt";
$lang['customer_id']="Kundennummer";
$lang['work']="bearbeiten";
$lang['please_choose_paperwork']="Bitte wählen Sie die Aufgabe aus!";
$lang['money']="Betrag";
$lang['what_is_packed']="Folgendes muss noch eingepackt und gespeichert werden!";
$lang['more_fields']="weitere Felder";
$lang['save']="speichern";
$lang['select_note']="Hinweistext auswählen";
$lang['nothing_to_show']="Nichts vorhanden!";
$lang['tax_nr']="Steuernummer:";
$lang['invoice_number']="Nummer";
$lang['offer_number']="Nummer";
$lang['order_number']="Nummer";
$lang['delivery_number']="Nummer";
$lang['all_customers_with_open_offers']="Nur Kunden mit offenen Angeboten";
$lang['all_customers_with_open_orders']="Nur Kunden mit offenen Bestellungen";
$lang['all_customers_with_open_deliveries']="Nur Kunden mit offenen Lieferungen";
$lang['all_customers_with_open_invoices']="Nur Kunden mit offenen Rechnungen";

// for configuration
$lang['user']="Benutzer";
$lang['user_id']="Benutzernummer";
$lang['value']="Wert";
$lang['config']="Einstellung";
$lang['everybody']="Jeder";
$lang['no_user']="keiner";
$lang['standard_value']="Standardwert";
$lang['deleted']="gelöscht";
$lang['missing']="%value% fehlt! ";
$lang['change_config']="Konfiguration ändern";
$lang['insert_config']="Konfiguration einfügen";
$lang['config_changed']="Konfiguration geändert";
?>