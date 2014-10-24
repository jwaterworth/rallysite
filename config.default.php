<?php
ini_set("display_errors", true);
date_default_timezone_set("Europe/London");

//Database
define("DB_HOST", "host");
define("DB_NAME", "rallysite");
define("DB_USERNAME", "username");
define("DB_PASSWORD", "password");

//Account Types
define('UNAPPROVED', 16);
define('MEMBER', 1);
define('CLUBREP', 2);
define('EVENTEXEC', 4);
define('SSAGOEXEC', 8);
define('APPROVED', 15); //Represents all approved types
define('ALLTYPES', 31); //Repesents all types

//Confirmation Types
define('ERROR', 0);
define('REGISTRATION', 1);
define('BOOKING', 2);
define('UPDATE_DETAILS', 3);
define('CLUB_REGISTRATON', 4);
define('CLUB_BOOKING' ,5);
define('CLUB_MEMBER_UPDATE', 6);

//Download TYPES
define('PARTICIPANT_LIST', 0);
define('ACTIVITY_LIST', 1);
define('CATERING_LIST', 2);

//Misc
define('WHOSGOING', 0);
define('WHOSDOING', 1);

//Paths
define("IMAGE_PATH" , "/images/");
define("ACTIVITY_IMAGES", "images/activities/");
define('DOWNLOADS_PATH', 'download/');
define("INTERNAL_IMAGE_PATH", "/disks/diskh/zco/cojw3/public_html/ssago/");
define("CLASS_PATH", "classes");
define("VO_PATH", "classes/value_objects");
define("FACTORY_PATH", "classes/factories");
define("DATA_FACTORY_PATH", "classes/factories/data_factories");
define("PRES_FACTORY_PATH", "classes/factories/logic_factories");
define("INTERFACE_PATH", "classes/interfaces");
define("DBLAYER_PATH", "classes/database_layer");
define("COMMON_TEMPLATES", "templates/common");
define("TEMPLATE_PATH", "templates");
define("BUSLOGIC_PATH", "classes/business_logic");
define("PAGE_CONTROLLERS", "classes/page_controllers");
        
//Value Objects
require_once(VO_PATH."/AccountTypeVO.inc.php");
require_once(VO_PATH."/AccountVO.inc.php");
require_once(VO_PATH."/ActivityPageVO.inc.php");
require_once(VO_PATH."/ActivityVO.inc.php");
require_once(VO_PATH."/BookingActivityVO.inc.php");
require_once(VO_PATH."/BookingInfoVO.inc.php");
require_once(VO_PATH."/BookingVO.inc.php");
require_once(VO_PATH."/BookingCompositeVO.inc.php");
require_once(VO_PATH."/ClubVO.inc.php");
require_once(VO_PATH."/EventVO.inc.php");
require_once(VO_PATH."/FeesVO.inc.php");
require_once(VO_PATH."/FoodChoiceVO.inc.php");
require_once(VO_PATH."/FoodTypeVO.inc.php");
require_once(VO_PATH."/BookingFoodChoiceVO.inc.php");
require_once(VO_PATH."/NewsPostVO.inc.php");
require_once(VO_PATH."/OpenSessionVO.inc.php");

//Authentication class
require_once("classes/auth/Authentication.inc.php");

//Upload Class
require_once("classes/upload/Uploads.inc.php");

//Email class
require_once(CLASS_PATH."/emails/Email.inc.php");

//Downloads class
require_once(CLASS_PATH.'/downloads/CSVGenerator.php');

//Factories
require_once(DATA_FACTORY_PATH."/AccountFactory.inc.php");
require_once(DATA_FACTORY_PATH."/AccountTypeFactory.inc.php");
require_once(DATA_FACTORY_PATH."/ClubFactory.inc.php");
require_once(DATA_FACTORY_PATH."/NewsPostFactory.inc.php");
require_once(DATA_FACTORY_PATH."/EventFactory.inc.php");
require_once(DATA_FACTORY_PATH."/ActivityPageFactory.inc.php");
require_once(DATA_FACTORY_PATH."/ActivityFactory.inc.php");
require_once(DATA_FACTORY_PATH."/BookingInfoFactory.inc.php");
require_once(DATA_FACTORY_PATH."/FeesFactory.inc.php");
require_once(DATA_FACTORY_PATH."/FoodChoiceFactory.inc.php");
require_once(DATA_FACTORY_PATH."/FoodTypeFactory.inc.php");
require_once(DATA_FACTORY_PATH."/BookingFactory.inc.php");
require_once(DATA_FACTORY_PATH."/BookingCompositeFactory.inc.php");
require_once(DATA_FACTORY_PATH."/BookingActivityFactory.inc.php");
require_once(DATA_FACTORY_PATH."/BookingFoodChoiceFactory.inc.php");
require_once(DATA_FACTORY_PATH."/OpenSessionFactory.inc.php");
require_once(PRES_FACTORY_PATH."/LogicFactory.inc.php");

?>