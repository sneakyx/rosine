<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * EgwAddressbook
 *
 * @ORM\Table(name="egw_addressbook", uniqueConstraints={@ORM\UniqueConstraint(name="egw_addressbook_account_id", columns={"account_id"})}, indexes={@ORM\Index(name="egw_addressbook_contact_owner", columns={"contact_owner"}), @ORM\Index(name="egw_addressbook_carddav_name", columns={"carddav_name"}), @ORM\Index(name="egw_addressbook_n_given_n_family", columns={"n_given", "n_family"}), @ORM\Index(name="egw_addressbook_n_fileas", columns={"n_fileas"}), @ORM\Index(name="egw_addressbook_contact_modified", columns={"contact_modified"}), @ORM\Index(name="egw_addressbook_n_family_n_given", columns={"n_family", "n_given"}), @ORM\Index(name="egw_addressbook_cat_id", columns={"cat_id"}), @ORM\Index(name="egw_addressbook_contact_uid", columns={"contact_uid"}), @ORM\Index(name="egw_addressbook_org_name_n_family_n_given", columns={"org_name", "n_family", "n_given"})})
 * @ORM\Entity
 */
class EgwAddressbook
{
    /**
     * @var int
     *
     * @ORM\Column(name="contact_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $contactId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_tid", type="string", length=1, nullable=true, options={"default"="n"})
     */
    private $contactTid = 'n';

    /**
     * @var int
     *
     * @ORM\Column(name="contact_owner", type="bigint", nullable=false)
     */
    private $contactOwner;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="contact_private", type="boolean", nullable=true)
     */
    private $contactPrivate = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="cat_id", type="string", length=255, nullable=true)
     */
    private $catId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="n_family", type="string", length=64, nullable=true)
     */
    private $nFamily;

    /**
     * @var string|null
     *
     * @ORM\Column(name="n_given", type="string", length=64, nullable=true)
     */
    private $nGiven;

    /**
     * @var string|null
     *
     * @ORM\Column(name="n_middle", type="string", length=64, nullable=true)
     */
    private $nMiddle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="n_prefix", type="string", length=64, nullable=true)
     */
    private $nPrefix;

    /**
     * @var string|null
     *
     * @ORM\Column(name="n_suffix", type="string", length=64, nullable=true)
     */
    private $nSuffix;

    /**
     * @var string|null
     *
     * @ORM\Column(name="n_fn", type="string", length=128, nullable=true)
     */
    private $nFn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="n_fileas", type="string", length=255, nullable=true)
     */
    private $nFileas;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_bday", type="string", length=12, nullable=true)
     */
    private $contactBday;

    /**
     * @var string|null
     *
     * @ORM\Column(name="org_name", type="string", length=128, nullable=true)
     */
    private $orgName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="org_unit", type="string", length=64, nullable=true)
     */
    private $orgUnit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_title", type="string", length=64, nullable=true)
     */
    private $contactTitle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_role", type="string", length=64, nullable=true)
     */
    private $contactRole;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_assistent", type="string", length=64, nullable=true)
     */
    private $contactAssistent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_room", type="string", length=64, nullable=true)
     */
    private $contactRoom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_one_street", type="string", length=64, nullable=true)
     */
    private $adrOneStreet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_one_street2", type="string", length=64, nullable=true)
     */
    private $adrOneStreet2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_one_locality", type="string", length=64, nullable=true)
     */
    private $adrOneLocality;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_one_region", type="string", length=64, nullable=true)
     */
    private $adrOneRegion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_one_postalcode", type="string", length=64, nullable=true)
     */
    private $adrOnePostalcode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_one_countryname", type="string", length=64, nullable=true)
     */
    private $adrOneCountryname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_label", type="text", length=65535, nullable=true)
     */
    private $contactLabel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_two_street", type="string", length=64, nullable=true)
     */
    private $adrTwoStreet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_two_street2", type="string", length=64, nullable=true)
     */
    private $adrTwoStreet2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_two_locality", type="string", length=64, nullable=true)
     */
    private $adrTwoLocality;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_two_region", type="string", length=64, nullable=true)
     */
    private $adrTwoRegion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_two_postalcode", type="string", length=64, nullable=true)
     */
    private $adrTwoPostalcode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_two_countryname", type="string", length=64, nullable=true)
     */
    private $adrTwoCountryname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_work", type="string", length=40, nullable=true)
     */
    private $telWork;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_cell", type="string", length=40, nullable=true)
     */
    private $telCell;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_fax", type="string", length=40, nullable=true)
     */
    private $telFax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_assistent", type="string", length=40, nullable=true)
     */
    private $telAssistent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_car", type="string", length=40, nullable=true)
     */
    private $telCar;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_pager", type="string", length=40, nullable=true)
     */
    private $telPager;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_home", type="string", length=40, nullable=true)
     */
    private $telHome;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_fax_home", type="string", length=40, nullable=true)
     */
    private $telFaxHome;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_cell_private", type="string", length=40, nullable=true)
     */
    private $telCellPrivate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_other", type="string", length=40, nullable=true)
     */
    private $telOther;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_prefer", type="string", length=32, nullable=true)
     */
    private $telPrefer;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_email", type="string", length=128, nullable=true)
     */
    private $contactEmail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_email_home", type="string", length=128, nullable=true)
     */
    private $contactEmailHome;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_url", type="string", length=128, nullable=true)
     */
    private $contactUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_url_home", type="string", length=128, nullable=true)
     */
    private $contactUrlHome;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_freebusy_uri", type="string", length=128, nullable=true)
     */
    private $contactFreebusyUri;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_calendar_uri", type="string", length=128, nullable=true)
     */
    private $contactCalendarUri;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_note", type="text", length=65535, nullable=true)
     */
    private $contactNote;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_tz", type="string", length=8, nullable=true)
     */
    private $contactTz;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_geo", type="string", length=32, nullable=true)
     */
    private $contactGeo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_pubkey", type="text", length=65535, nullable=true)
     */
    private $contactPubkey;

    /**
     * @var int|null
     *
     * @ORM\Column(name="contact_created", type="bigint", nullable=true)
     */
    private $contactCreated;

    /**
     * @var int
     *
     * @ORM\Column(name="contact_creator", type="integer", nullable=false)
     */
    private $contactCreator;

    /**
     * @var int
     *
     * @ORM\Column(name="contact_modified", type="bigint", nullable=false)
     */
    private $contactModified;

    /**
     * @var int|null
     *
     * @ORM\Column(name="contact_modifier", type="integer", nullable=true)
     */
    private $contactModifier;

    /**
     * @var int|null
     *
     * @ORM\Column(name="account_id", type="integer", nullable=true)
     */
    private $accountId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="contact_etag", type="integer", nullable=true)
     */
    private $contactEtag = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_uid", type="string", length=255, nullable=true)
     */
    private $contactUid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_one_countrycode", type="string", length=2, nullable=true)
     */
    private $adrOneCountrycode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_two_countrycode", type="string", length=2, nullable=true)
     */
    private $adrTwoCountrycode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="carddav_name", type="string", length=64, nullable=true)
     */
    private $carddavName;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="contact_files", type="boolean", nullable=true)
     */
    private $contactFiles = '0';


}
