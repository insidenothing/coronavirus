<?PHP
include_once('/var/www/secure.php'); //outside webserver
include_once('../functions.php'); //outside webserver
$page_description = 'Maryland Facilities Data';
include_once('../menu.php');

global $Facility_ZIP;
$Facility_ZIP['Anchorage_Healthcare_Center'] = '21801';
$Facility_ZIP['Arbor_Terrace_Fulton']  = '20759';
$Facility_ZIP['Arden_Courts_of_Pikesville'] = '21208';
$Facility_ZIP['Aspenwood_Senior_Living_Community'] = '20906';
$Facility_ZIP['Atrium_Village'] = '21117';
$Facility_ZIP['Autumn_Lake_Healthcare_at_Bridgepark'] = '21207';
$Facility_ZIP['Autumn_Lake_Healthcare_at_Cherry_Lane'] = '20708';
$Facility_ZIP['Autumn_Lake_Healthcare_at_Oakview'] = '20910';
$Facility_ZIP['Autumn_Lake_Healthcare_at_Riverview'] = '21221';
$Facility_ZIP['Ballenger_Creek___Genesis_Healthcare'] = '21703';
$Facility_ZIP['Berlin_Nursing_and_Rehabilitation_Center'] = '21811';
$Facility_ZIP['Bethesda_Health_and_Rehab'] = '20814';
$Facility_ZIP['Birch_Manor_Healthcare_Center'] = '21784';
$Facility_ZIP['Blue_Point_Healthcare_Center'] = '21215';
$Facility_ZIP['Brighton_Gardens_at_Friendship_Heights'] = '20815';
$Facility_ZIP['Brighton_Gardens_of_Columbia'] = '21045';
$Facility_ZIP['Brighton_Gardens_of_Tuckerman_Lane'] = '20852';
$Facility_ZIP['Brightview_Fallsgrove_Rockville_Senior_Assisted_Living_and_Memory_Care'] = '20850';
$Facility_ZIP['Brinton_Woods_Health___Rehabilitation_Center_at_Winfield'] = '21784';
$Facility_ZIP['Brookdale_of_Towson'] = '21212';
$Facility_ZIP['Brookdale_Olney'] = '20832';
$Facility_ZIP['Brooke_Grove_Retirement_Community'] = '20860';
$Facility_ZIP['Cadia_Healthcare___Hagerstown'] = '21742';
$Facility_ZIP['Cadia_Healthcare_Wheaton'] = '20902';
$Facility_ZIP['Cadia_Hyattsville'] = '20782';
$Facility_ZIP['Charlestown_Senior_Living_Community'] = '21228';
$Facility_ZIP['Charlotte_Hall_Veterans_Home'] = '20622';
$Facility_ZIP['Chesapeake_Woods_Center'] = '21613';
$Facility_ZIP['Citizens_Care_and_Rehabilitation_Center___Frederick'] = '21702';
$Facility_ZIP['Collingswood_Rehabilitation_and_Healthcare_Center'] = '20850';
$Facility_ZIP['Copper_Ridge'] = '21784';
$Facility_ZIP['Corsica_Hills_Center'] = '21617';
$Facility_ZIP['Crofton_Care_and_Rehabilitation'] = '21114';
$Facility_ZIP['Cumberland_Healthcare_Center'] = '21502';
$Facility_ZIP['Doctors_Community_Rehabilitation_and_Patient_Care_Center'] = '20706';
$Facility_ZIP['Edenwald'] = '21286';
$Facility_ZIP['Fayette_Health_and_Rehabilitation_Center'] = '21223';
$Facility_ZIP['Fox_Chase_Rehabilitation___Nursing'] = '20910';
$Facility_ZIP['Frederick_Health_and_Rehabilitation_Center'] = '21701';
$Facility_ZIP['Frederick_Villa_Nursing_and_Rehabilitation_Center'] = '21228';
$Facility_ZIP['Friends_House_Retirement_Community'] = '20860';
$Facility_ZIP['Future_Care_Irvington'] = '21229';
$Facility_ZIP['FutureCare_Irvington'] = '21229';
$Facility_ZIP['FutureCare_Canton_Harbor'] = '21224';
$Facility_ZIP['FutureCare_Courtland'] = '21208';
$Facility_ZIP['FutureCare_Homewood'] = '21218';
$Facility_ZIP['FutureCare_Sandtown'] = '21217';
$Facility_ZIP['Genesis_Catonsville_Commons'] = '21228';
$Facility_ZIP['Genesis_Cromwell_Center'] = '21234';
$Facility_ZIP['Genesis_Hammonds_Lane'] = '21225';
$Facility_ZIP['Genesis_Long_Green_Center'] = '21212';
$Facility_ZIP['Genesis_Severna_Park'] = '21146';
$Facility_ZIP['Genesis_Waugh_Chapel'] = '21054';
$Facility_ZIP['Ginger_Cove'] = '21401';
$Facility_ZIP['Glen_Burnie_Health_and_Rehabilitation_Center'] = '21060';
$Facility_ZIP['Glen_Meadows_Retirement_Community'] = '21057';
$Facility_ZIP['Greater_Baltimore_Medical_Center_Sub_Acute_Unit'] = '21204';
$Facility_ZIP['HeartFields_Assisted_Living_at_Frederick'] = '21701';
$Facility_ZIP['HeartLands_Senior_Living_Village_at_Ellicott_City'] = '21043';
$Facility_ZIP['Hebrew_Home_of_Greater_Washington'] = '20852';
$Facility_ZIP['Henson_Creek_Assisted_Living'] = '20748';
$Facility_ZIP['Heritage_Center_Genesis_Eldercare'] = '21222';
$Facility_ZIP['Holly_Hills_Manor'] = '21286';
$Facility_ZIP['Hyattsville_Health_and_Rehab'] = '20783';
$Facility_ZIP['Ingleside_at_King_Farm'] = '20850';
$Facility_ZIP['King_David_Nursing_and_Rehabilitation_Center'] = '21208';
$Facility_ZIP['Largo_Nursing___Rehabilitation_Center'] = '20774';
$Facility_ZIP['Layhill_Center'] = '20906';
$Facility_ZIP['Levindale_Hebrew_Geriatric_Center_and_Hospital'] = '21215';
$Facility_ZIP['Little_Sisters_of_the_Poor'] = '21228';
$Facility_ZIP['Longview_Nursing_Home_Inc_'] = '21102';
$Facility_ZIP['Lorien_Columbia'] = '21044';
$Facility_ZIP['Lorien_Mount_Airy'] = '21771';
$Facility_ZIP['Lorien_Taneytown'] = '21787';
$Facility_ZIP['Manor_Care_Roland_Park'] = '21209';
$Facility_ZIP['Manor_Care_Wheaton'] = '20902';
$Facility_ZIP['ManorCare_Health_Services___Ruxton'] = '21204';
$Facility_ZIP['ManorCare_Health_Services__Rossville'] = '21237';
$Facility_ZIP['ManorCare_Health_Services__Towson'] = '21286';
$Facility_ZIP['Maria_Health_Care_Center'] = '21212';
$Facility_ZIP['Meadow_Park_Rehabilitation_and_Healthcare'] = '21228';
$Facility_ZIP['Montgomery_Village_Health_Care_Center'] = '20886';
$Facility_ZIP['Morningside_House_of_Ellicott_City'] = '21042';
$Facility_ZIP['North_Oak'] = '21208';
$Facility_ZIP['Northwest_Health_and_Rehab_Center'] = '21215';
$Facility_ZIP['Nursing_and_Rehab_Center_at_Stadium_Place'] = '21218';
$Facility_ZIP['Oak_Crest'] = '21234';
$Facility_ZIP['Orchard_Hill_Health_and_Rehab'] = '21204';
$Facility_ZIP['Patapsco_Valley_Center'] = '21133';
$Facility_ZIP['Peak_Health_Caton_Manor'] = '21229';
$Facility_ZIP['Peake_Healthcare_at_Hartley_Hall__Autumn_Lake_Healthcare_at_Hartley_Hall_'] = '21851';
$Facility_ZIP['Peake_Healthcare_at_the_Pines'] = '21601';
$Facility_ZIP['Pleasant_View_Nursing_Home'] = '21771';
$Facility_ZIP['Post_Acute_Care_Center'] = '21206';
$Facility_ZIP['Potomac_Valley_Rehabilitation_and_Healthcare_Center'] = '20850';
$Facility_ZIP['PowerBack_Rehabilitation__Brightwood_Campus'] = '21093';
$Facility_ZIP['Regency_Care_of_Silver_Spring'] = '20910';
$Facility_ZIP['SagePoint_Nursing_and_Rehabilitation'] = '20646';
$Facility_ZIP['Salisbury_Rehabilitation_and_Nursing_Center'] = '21804';
$Facility_ZIP['Seabury_at_Springvale_Terrace'] = '20910';
$Facility_ZIP['Shady_Grove_Center_for_Nursing___Rehabilitation'] = '20850';
$Facility_ZIP['Shangri_La_Assisted_Living'] = '21043';
$Facility_ZIP['Sligo_Creek_Center___Peak_Healthcare'] = '20912';
$Facility_ZIP['Spa_Creek_Center'] = '21403';
$Facility_ZIP['St__Mary_s_Nursing_Center'] = '20650';
$Facility_ZIP['Stella_Maris'] = '21093';
$Facility_ZIP['Sterling_Care_South_Mountain'] = '21713';
$Facility_ZIP['Summit_Park_Health___Rehabilitation_Center'] = '21228';
$Facility_ZIP['Sunrise_of_Columbia'] = '21044';
$Facility_ZIP['Sunrise_Senior_Living_Bethesda'] = '20814';
$Facility_ZIP['The_Cottages_of_Perry_Hall'] = '21234';
$Facility_ZIP['The_Charleston_Senior_Community'] = '20603';
$Facility_ZIP['The_Neighborhoods_at_St__Elizabeth_Rehabilitation___Nursing_Center'] = '21227';
$Facility_ZIP['The_Peartree_House_Assisted_Living'] = '21122';
$Facility_ZIP['The_Resort_at_Chester_Manor'] = '21620';
$Facility_ZIP['Tribute_at_Black_Hill'] = '20874';
$Facility_ZIP['Tudor_Heights_Assisted_Living'] = '21208';
$Facility_ZIP['Village_at_Augsburg____Nursing_Home'] = '21207';
$Facility_ZIP['Village_at_Rockville'] = '20850';
$Facility_ZIP['Westgate_Hills_Rehabilitation___Healthcare_Center'] = '21229';
$Facility_ZIP['Westminster_Healthcare_Center'] = '21157';

$Facility_ZIP['Anne_Arundel_Detention_Center_Jennifer_Road'] = '21401';
$Facility_ZIP['Baltimore_County_Detention_Center'] = '21204';
$Facility_ZIP['Prince_George_s_County_Jail'] = '20772';
$Facility_ZIP['Springfield_Hospital_Center'] = '21784';
$Facility_ZIP['Baltimore_Central_Booking_and_Intake_Center'] = '21202';
$Facility_ZIP['Chesapeake_Detention_Facility__Formerly_MCAC_'] = '21202';
$Facility_ZIP['Metropolitan_Transition_Center'] = '21202';
$Facility_ZIP['Youth_Detention_Center'] = '21202';
$Facility_ZIP['Baltimore_City_Correctional_Center'] = '21202';
$Facility_ZIP['Maryland_Reception__Diagnostic_and_Classification_Center'] = '21202';
$Facility_ZIP['Dorsey_Run_Correctional_Facility'] = '20794';
$Facility_ZIP['Jessup_Correctional_Institution___Including_Baltimore_Pretrial_Complex__BPFJ_'] = '20794';
$Facility_ZIP['Maryland_Correctional_Institution_for_Women'] = '20794';
$Facility_ZIP['Maryland_Correctional_Institution___Jessup'] = '20794';
$Facility_ZIP['Patuxent_Institution___Including_Correctional_Mental_Health_Center_Jessup'] = '20794';
$Facility_ZIP['Central_Maryland_Correctional_Facility__Formerly_CLF_'] = '21784';
$Facility_ZIP['Southern_Maryland_Pre_Release_Unit'] = '20622';
$Facility_ZIP['Eastern_Correctional_Institution'] = '21890';
$Facility_ZIP['Eastern_Correctional_Institution_Annex'] = '21890';
$Facility_ZIP['Maryland_Correctional_Institution_Hagerstown'] = '21746';
$Facility_ZIP['Maryland_Correctional_Training_Center'] = '21746';
$Facility_ZIP['Roxbury_Correctional_Institution'] = '21746';
$Facility_ZIP['North_Branch_Correctional_Institution'] = '21502';
$Facility_ZIP['Western_Correctional_Institution'] = '21502';
$Facility_ZIP['Charles_H__Hickey__Jr__School'] = '21234';


$Facility_ZIP['Woodholme_Garden'] = '21208';
$Facility_ZIP['Baltimore_City_Juvenile_Justice_Center'] = '21202';
$Facility_ZIP['Clifton_T__Perkins_Hospital_Center'] = '20794';
$Facility_ZIP['Arbor_Terrace_Waugh_Chapel'] = '21113';
$Facility_ZIP['Arden_Courts_of_Silver_Spring'] = '20904';
$Facility_ZIP['Brightview_Severna_Park'] = '21146';
$Facility_ZIP['Commonwealth_Senior_Living_Cockeysville'] = '21030';
$Facility_ZIP['Encore_at_Turf_Valley'] = '21042';
$Facility_ZIP['FutureCare_Northpoint'] = '21224';
$Facility_ZIP['Genesis_Perring_Parkway'] = '21234';
$Facility_ZIP['Glade_Valley_Center___Genesis_Healthcare'] = '21793';
$Facility_ZIP['Kensington_Park'] = '20895';
$Facility_ZIP['Keswick_Multi_Care_Center'] = '21211';
$Facility_ZIP['Lighthouse_Senior_Living_at_Ellicott_City'] = '21043';
$Facility_ZIP['Lighthouse_Senior_Living_at_Hopkins_Creek'] = '21221';
$Facility_ZIP['Overlea_Health_and_Rehab'] = '21206';
$Facility_ZIP['St__John_Neumann_Residence'] = '21093';
$Facility_ZIP['Sterling_at_Riverside'] = '21017';
$Facility_ZIP['The_Landing_of_Silver_Spring'] = '20904';


$Facility_ZIP['Anna_Politan_Assisted_Living'] = '21409';
$Facility_ZIP['Brightview_White_Marsh___Brightview_Senior_Living'] = '21236';
$Facility_ZIP['Broadmead'] = '21030';
$Facility_ZIP['Dennett_Road_Manor'] = '21550';
$Facility_ZIP['Discovery_Commons_at_Wildewood'] = '20619';
$Facility_ZIP['Genesis_La_Plata'] = '20646';
$Facility_ZIP['Genesis_Multi_Medical_Center'] = '21204';
$Facility_ZIP['Howard_County_Detention_Center'] = '20794';
$Facility_ZIP['Lorien_Elkridge'] = '21075';
$Facility_ZIP['New_Life_Healthy_Living_Center'] = '21244';
$Facility_ZIP['Northampton_Manor_Nursing_and_Rehabilitation_Center'] = '21701';
$Facility_ZIP['Potomac_Center'] = '21740';
$Facility_ZIP['Restore_Health_Rehabilitation_Center'] = '20695';
$Facility_ZIP['Rockville_Nursing_Home'] = '20850';
$Facility_ZIP['Somerford_Place_Columbia'] = '21045';
$Facility_ZIP['Sunrise_of_Pikesville'] = '21208';
$Facility_ZIP['Thoms_J_S__Waxter_Children_s_Center'] = '20724';
$Facility_ZIP['Western_Maryland_Hospital_Center'] = '21742';

$Facility_ZIP['Arbor_Terrace_Senior_Living'] = '20706';
$Facility_ZIP['Arcola_Health_and_Rehabilitation_Center'] = '20902';
$Facility_ZIP['Bedford_Court'] = '20906';
$Facility_ZIP['Bel_Air_Health_and_Rehabilitation_Center'] = '21014';
$Facility_ZIP['Brightview_Assisted_Living_Catonsville'] = '21228';
$Facility_ZIP['Brightview_Senior_Living_Annapolis'] = '21401';
$Facility_ZIP['Brightview_Senior_Living_Rolling_Hills'] = '21228';
$Facility_ZIP['Brightview_Towson'] = '21286';
$Facility_ZIP['Brookdale_Woodward_Estates'] = '20716';
$Facility_ZIP['Cadia_Health_Springbrook'] = '20904';
$Facility_ZIP['Chapel_Hill_Nursing_Center'] = '21133';
$Facility_ZIP['Commonwealth_Senior_Living_Hagerstown'] = '21740';
$Facility_ZIP['Fahrney_Keedy_Home_and_Village'] = '21713';
$Facility_ZIP['Foxchase_Rehabilitation_and_Nursing_Center'] = '20910';
$Facility_ZIP['Future_Care_Charles_Village'] = '21218';
$Facility_ZIP['FutureCare_Charles_Village'] = '21218';
$Facility_ZIP['Genesis_Eldercare_Franklin_Woods'] = '21237';
$Facility_ZIP['Genesis_Homewood_Center'] = '21212';
$Facility_ZIP['Genesis_Loch_Raven'] = '21234';
$Facility_ZIP['Goodwill_Retirement_Community'] = '21536';
$Facility_ZIP['Homestead_Manor'] = '21629';
$Facility_ZIP['In_Good_Hands_Assisted_Living'] = '21085';
$Facility_ZIP['Lorien_Mays_Chapel'] = '21093';
$Facility_ZIP['Marley_Neck_Health_and_Rehabilitation_Center'] = '21060';
$Facility_ZIP['Northwest_Hospital_Center___Subacute_rehab_facility'] = '21133';
$Facility_ZIP['Oakwood_Care_Center'] = '21220';
$Facility_ZIP['Pickersgill_Retirement'] = '21204';
$Facility_ZIP['Pleasant_Gardens_Assisted_Living'] = '21206';
$Facility_ZIP['Residences_at_Vantage_Point'] = '21044';
$Facility_ZIP['Ridgeway_Manor'] = '21228';
$Facility_ZIP['Rockville_Nursing_and_Rehab'] = '20850';
$Facility_ZIP['Somerford_House_Frederick'] = '21702';
$Facility_ZIP['St__Joseph_s_Nursing_Home'] = '21228';
$Facility_ZIP['Wilson_Healthcare_Center'] = '20877';


$Facility_ZIP['Adelphi_Nursing_and_Rehabilitation'] = '20783';
$Facility_ZIP['Alfred_D__Noyes_Children_s_Center'] = '20850';
$Facility_ZIP['Alfred_House'] = '20853';
$Facility_ZIP['Alfred_House_One'] = '20853';
$Facility_ZIP['Althea_Woodland'] = '20901';
$Facility_ZIP['Arbor_Place'] = '20853';
$Facility_ZIP['Arden_Courts_of_Kensington'] = '20895';
$Facility_ZIP['Arden_Courts_of_Potomac'] = '20854';
$Facility_ZIP['Arden_Courts_of_Towson'] = '21204';
$Facility_ZIP['Arden_Court_of_Towson'] = '21204';
$Facility_ZIP['Arlington_West_Care_Center'] = '21215';
$Facility_ZIP['Asbury_Solomons'] = '20688';
$Facility_ZIP['Atria_Manresa'] = '21409';
$Facility_ZIP['Autumn_Lake_at_Alice_Manor'] = '21211';
$Facility_ZIP['Autumn_Lake_Hartley_Hall'] = '21851';
$Facility_ZIP['Autumn_Lake_Healthcare_at_Denton'] = '21629';
$Facility_ZIP['Autumn_Lake_Healthcare_at_Hartley_Hall'] = '21851';
$Facility_ZIP['Autumn_Lake_Kent_County'] = '21620';
$Facility_ZIP['Autumn_Lake_Pikesville'] = '21208';
$Facility_ZIP['Backbone_Mountain_Youth_Center'] = '21561';
$Facility_ZIP['Bayleigh_Chase'] = '21601';
$Facility_ZIP['Baywoods_of_Annapolis'] = '21403';
$Facility_ZIP['Bel_Pre_Healthcare_Center'] = '20906';
$Facility_ZIP['Blakehurst_Lifecare_Community'] = '21204';
$Facility_ZIP['Bradford_Oaks_Center'] = '20735';
$Facility_ZIP['Brighton_Gardens_at_Frienship_Heights'] = '20815';
$Facility_ZIP['Brightview_Mays_Chapel_Hill'] = '21093';
$Facility_ZIP['Brightview_Senior_Living'] = '21201';
$Facility_ZIP['Brightview_South_River___Senior_Assisted_Living_and_Memory_Care'] = '21037';
$Facility_ZIP['Brightview_West_End___Brightview_Senior_Living'] = '20850';
$Facility_ZIP['Brightview_Woodmont_Bethesda'] = '20814';
$Facility_ZIP['Brockbridge_Correctional_Facility__currently_being_repurposed'] = '20794';
$Facility_ZIP['Brookdale_Pikesville'] = '21208';
$Facility_ZIP['Brookdale_Potomac_Assisted_Living'] = '20854';
$Facility_ZIP['Brookeville_House'] = '20833';
$Facility_ZIP['Buckingham_s_Choice'] = '21710';
$Facility_ZIP['Cadia_Healthcare_Annapolis'] = '21403';
$Facility_ZIP['Cadia_Healthcare_of_Springbrook__MD'] = '20904';
$Facility_ZIP['Calvert_County_Nursing_Center'] = '20678';
$Facility_ZIP['Calvert_Manor_Healthcare_Center'] = '21911';
$Facility_ZIP['Carriage_Hill'] = '20814';
$Facility_ZIP['Carroll_Lutheran_Village'] = '21158';
$Facility_ZIP['Cedar_Creek_Memory_Care_Homes__Maple_Ridge'] = '20853';
$Facility_ZIP['Chapel_Hill_Nursing_and_Rehabilitation_Center'] = '21133';
$Facility_ZIP['Charles_County_Detention_Center'] = '20646';
$Facility_ZIP['Cheltenham_Youth_Detention_Center'] = '20623';
$Facility_ZIP['Chesapeake_Cove'] = '21817';
$Facility_ZIP['Chesapeake_Shores'] = '20653';
$Facility_ZIP['Chesapeake_Treatment_Center'] = '21234';
$Facility_ZIP['Citizens_Care_and_Rehabilitation_Center_of_Frederick'] = '21702';
$Facility_ZIP['Citizens_Care_and_Rehabilitation_Center___Havre_de_Grace'] = '21078';
$Facility_ZIP['Clinton_Nursing_and_Rehabilitation_Center'] = '20735';
$Facility_ZIP['Collington'] = '20721';
$Facility_ZIP['Country_Meadows_of_Frederick'] = '21704';
$Facility_ZIP['Crescent_Cities'] = '20737';
$Facility_ZIP['Diakon_Senior_Living___Hagerstown_Robinwood_Campus'] = '21742';
$Facility_ZIP['Discovery_Commons_at_Wild_Wood'] = '20619';
$Facility_ZIP['Dorcester_County_Detention_Center'] = '21613';
$Facility_ZIP['Eastern_Pre_Release_Unit'] = '21623';
$Facility_ZIP['Eastern_Shore_Hospital_Center'] = '21613';
$Facility_ZIP['Edenton_Retirement_Community'] = '21703';
$Facility_ZIP['Elizabeth_Manor'] = '20706';
$Facility_ZIP['Ellicott_City_Healthcare_Center'] = '21043';
$Facility_ZIP['Esther_s_Place_at_Pinewood'] = '21214';
$Facility_ZIP['Esther_s_Place_At_the_Park'] = '21218';
$Facility_ZIP['Fahrney_Keedy_Memorial_Home_and_Village'] = '00000';
$Facility_ZIP['Fairfield_Nursing_and_Rehabilitation_Center'] = '21032';
$Facility_ZIP['Fairhaven'] = '21784';
$Facility_ZIP['Fairland_Center'] = '20904';
$Facility_ZIP['Fayette_Nursing_and_Rehabilitation'] = '21223';
$Facility_ZIP['Forestville_Healthcare_Center'] = '20747';
$Facility_ZIP['Forest_Haven_Nursing___Rahab_Center'] = '21201';
$Facility_ZIP['Forest_Hill_Health___Rehab_Center'] = '21050';
$Facility_ZIP['Fort_Washington_Health_Center'] = '20744';
$Facility_ZIP['Futurecare_Cherrywood'] = '21136';
$Facility_ZIP['FutureCare_Chesapeake'] = '21012';
$Facility_ZIP['FutureCare_Cold_Spring'] = '21214';
$Facility_ZIP['FutureCare_Good_Samaritan'] = '21239';
$Facility_ZIP['FutureCare_Lochearn'] = '21215';
$Facility_ZIP['FutureCare_Old_Court'] = '21133';
$Facility_ZIP['FutureCare_Pineview'] = '20735';
$Facility_ZIP['Future_Care_Capitol_Region'] = '20785';
$Facility_ZIP['FutureCare_Capitol_Region'] = '20785';
$Facility_ZIP['Future_Care_Pineview'] = '20735';
$Facility_ZIP['FutureCare_Pineview'] = '20735';
$Facility_ZIP['Genesis_Long_Green'] = '21212';
$Facility_ZIP['Genesis_Waldorf'] = '20602';
$Facility_ZIP['Golden_Crest_1'] = '21074';
$Facility_ZIP['Golden_Crest_2'] = '21157';
$Facility_ZIP['Green_Ridge_Youth_Center'] = '21530';
$Facility_ZIP['Gull_Creek'] = '21811';
$Facility_ZIP['Hagerstown_Healthcare_Center'] = '21740';
$Facility_ZIP['Heritage_Harbour_Health_and_Rehabilitation_Center'] = '21401';
$Facility_ZIP['Heron_Point_of_Chestertown'] = '21620';
$Facility_ZIP['Hillhaven_Assisted_Living__Nursing_and_Rehabilitation_Center'] = '20783';
$Facility_ZIP['Homewood_at_Frederick'] = '21702';
$Facility_ZIP['Homewood_Hilltop'] = '21212';
$Facility_ZIP['Inspirations_Memory_Care_of_Westminster'] = '21157';
$Facility_ZIP['Inspiration_Memory_Care_Linthicum'] = '21090';
$Facility_ZIP['Jessup_Correctional_Institution__Including_Baltimore_Pretrial_Complex__BPFJ_'] = '20794';
$Facility_ZIP['Jewish_Community_Services_Laurelwood'] = '21921';
$Facility_ZIP['JK_House_of_Grace'] = '20906';
$Facility_ZIP['Kensington_Healthcare_Center'] = '20895';
$Facility_ZIP['Kindley_Assisted_Living_at_Asbury_Methodist_Village'] = '20877';
$Facility_ZIP['Larkin_Chase_Center'] = '20716';
$Facility_ZIP['Lorien_Bulle_Rock'] = '21078';
$Facility_ZIP['Lorien_Harmony_Hall'] = '21044';
$Facility_ZIP['Lower_Eastern_Shore_Children_s_Center_J__DeWeese_Carter_Center'] = '21620';
$Facility_ZIP['Lutheran_Village_at_Miller_s_Grant'] = '21042';
$Facility_ZIP['Manokin_Rehab_and_Healthcare_Services'] = '21853';
$Facility_ZIP['ManorCare_Health_Services_Bethesda'] = '20817';
$Facility_ZIP['ManorCare_Health_Services___Chevy_Chase'] = '20815';
$Facility_ZIP['ManorCare_Potomac'] = '20854';
$Facility_ZIP['Manor_Care_Silver_Spring'] = '20904';
$Facility_ZIP['Maplewood_of_Park_Place__Sunrise_Senior_Living'] = '20814';
$Facility_ZIP['Marian_Assisted_Living'] = '20833';
$Facility_ZIP['Maryland_Correctional_Institution___Hagerstown'] = '21746';
$Facility_ZIP['Maryland_Masonic_Homes'] = '21030';
$Facility_ZIP['Ma_Maison_Assisted_Living'] = '21236';
$Facility_ZIP['Meadow_Mountain_Youth_Center'] = '21536';
$Facility_ZIP['Meadow_Mountain_Youth_Center_'] = '21536';
$Facility_ZIP['Montevue_Assisted_Living'] = '21702';
$Facility_ZIP['Moran_Manor_Nursing_and_Rehabilitation_Center'] = '21229';
$Facility_ZIP['Morningside_House_of_Friendship'] = '21076';
$Facility_ZIP['Morningside_House_of_St_Charles'] = '20602';
$Facility_ZIP['New_Life_Health_Living'] = '21244';
$Facility_ZIP['North_Arundel_Health_and_Rehabilitation_Center'] = '21061';
$Facility_ZIP['Oak_Manor_Center'] = '20866';
$Facility_ZIP['Olney_Memory_Care'] = '20832';
$Facility_ZIP['Ordnance_Road_Detention_Center'] = '21060';
$Facility_ZIP['Paradise_Assisted_Living'] = '21228';
$Facility_ZIP['Patuxent_Institution__Including_Correctional_Mental_Health_Center_Jessup'] = '20794';
$Facility_ZIP['Patuxent_River_Health_and_Rehabilitation_Center'] = '20707';
$Facility_ZIP['Peak_Healthcare_Chestertown'] = '21620';
$Facility_ZIP['Ravenwood_Nursing_Care_Center'] = '21201';
$Facility_ZIP['Regency_Park_Assisted_Living'] = '21054';
$Facility_ZIP['Riderwood_Village___Arbor_Ridge'] = '20705';
$Facility_ZIP['Riderwood___Arbor_Ridge'] = '20705';
$Facility_ZIP['Roland_Park_Place'] = '21211';
$Facility_ZIP['Rosemarie_Manor_Inc_'] = '21216';
$Facility_ZIP['Sacred_Heart_Home_Inc'] = '20782';
$Facility_ZIP['Sagepoint_Nursing___Rehabilitation'] = '20646';
$Facility_ZIP['Signature_Healthcare_at_Mallard_Bay'] = '21613';
$Facility_ZIP['Silver_Oak_Academy'] = '21757';
$Facility_ZIP['Sligo_Creek_Center___Genesis_Healthcare'] = '20912';
$Facility_ZIP['Solomons_Nursing_Center'] = '20688';
$Facility_ZIP['Somerford_Assisted_Living'] = '21401';
$Facility_ZIP['Somerset_County_Detention_Center'] = '21871';
$Facility_ZIP['South_River_Healthcare_Center'] = '21037';
$Facility_ZIP['Springwell_Senior_Living'] = '21209';
$Facility_ZIP['Spring_Arbor_of_Frederick'] = '21703';
$Facility_ZIP['Spring_Arbor_Senior_Living'] = '21146';
$Facility_ZIP['Spring_Grove_Psychiatric_Hospital'] = '21228';
$Facility_ZIP['Sterling_Care_at_Harbor_Point'] = '21801';
$Facility_ZIP['Sterling_Care_Frostburg_Village'] = '21532';
$Facility_ZIP['St__Mary_s_County_Detention_Center'] = '20650';
$Facility_ZIP['Sunrise_at_Montgomery_Village'] = '20886';
$Facility_ZIP['Sunrise_of_Chevy_Chase'] = '20910';
$Facility_ZIP['Sunrise_of_Rockville'] = '20850';
$Facility_ZIP['Sunrise_of_Severna_Park'] = '21146';
$Facility_ZIP['Sunrise_Senior_Living_in_Bethesda'] = '20814';
$Facility_ZIP['Sunrise_Senior_Living___Sunrise_at_Fox_Hill'] = '20817';
$Facility_ZIP['Sun_Valley_Assisted_Living'] = '21157';
$Facility_ZIP['Sun_Valley_at_Homestead'] = '21784';
$Facility_ZIP['Symphony_Manor_Baltimore'] = '21210';
$Facility_ZIP['The_Manor'] = '20748';
$Facility_ZIP['The_Thomas_B__Finan_Center'] = '21502';
$Facility_ZIP['The_W_Assisted_LIving'] = '20774';
$Facility_ZIP['Thomas_J_S__Waxter_Children_s_Center'] = '20724';
$Facility_ZIP['Tranquility_of_Frederickstowne'] = '21703';
$Facility_ZIP['Victor_Cullen_Center'] = '21780';
$Facility_ZIP['Victor_Cullen_Center_Savage_Mountain_Youth_Center'] = '21780';
$Facility_ZIP['Village_at_Augsburg'] = '21207';
$Facility_ZIP['Village_at_Augsburg____Assisted_Living'] = '21207';
$Facility_ZIP['Villa_Rosa_Nursing___Rehabilitation_Center'] = '20721';
$Facility_ZIP['Waxter_Center'] = '21201';
$Facility_ZIP['Western_Maryland_Children_s_Center'] = '21740';
$Facility_ZIP['Wicomico_Detention_Center'] = '21801';
$Facility_ZIP['Wilson_Health_Care_Center_at_Asbury_Methodist_Village'] = '20877';
$Facility_ZIP['Wintergrowth_Assisted_Living'] = '21044';
$Facility_ZIP['Worcester_County_Detention_Center'] = '21863';

$Facility_ZIP['Fahrney_Keedy_Memorial_Home_and_Village'] = '21713';
$Facility_ZIP['Forest_Haven_Nursing___Rehab_Center'] = '21201';



function cleanup_county($str){
   $str = str_replace("Anne Arundel",'Anne_Arundel',$str);
   $str = str_replace("Baltimore County",'Baltimore',$str);
   $str = str_replace("Baltimore City",'Baltimore_City',$str);
   $str = str_replace("Queen Anne's",'Queen_Annes',$str);
   $str = str_replace("St. Mary's",'St_Marys',$str);
   $str = str_replace("Prince George's",'Prince_Georges',$str);
   return $str; 
}

function cleanup($str){
   $str = trim($str);
   $str = str_replace("\n",'_',$str);
   $str = str_replace("'",'_',$str);
   $str = str_replace(",",'_',$str);
   $str = str_replace(".",'_',$str);
   $str = str_replace("&",'_',$str);
   $str = str_replace("*",'_',$str);
   $str = str_replace("/",'_',$str);
   $str = str_replace("(",'_',$str);
   $str = str_replace(")",'_',$str); 
   $str = str_replace("-",'_',$str); 
   $str = str_replace("-",'_',$str); 
   $str = str_replace(" ",'_',$str);
   // Normalize Facility Names
   $str = str_replace("Future_Care",'FutureCare',$str); 
   return $str; 
}


function coronavirus_Facility($Facility_Name,$zip,$date,$count,$Number_of_Resident_Cases,$Number_of_Staff_Cases,$Number_of_Resident_Deaths,$Number_of_Staff_Deaths,$Resident_Type,$county_name){
	global $Facility_ZIP;
	// the order we call the function will matter...
	global $covid_db;
	$Facility_Name = cleanup($Facility_Name);
	$q = "select * from coronavirus_facility where Facility_Name = '$Facility_Name' and report_date = '$date'";
	$r = $covid_db->query($q);
	$d = mysqli_fetch_array($r);
	// look for yesterday
	$date2 = date('Y-m-d',strtotime($date)-86400);
	$q2 = "select * from coronavirus_facility where Facility_Name = '$Facility_Name' and report_date = '$date2'";
	$r2 = $covid_db->query($q2);
	$d2 = mysqli_fetch_array($r2);
	if ($d2['id'] != ''){
		// Let's Process Trend Data
		$last_trend_direction = $d2['trend_direction'];
		$last_trend_duration = $d2['trend_duration'];
		$last_report_count = $d2['report_count'];
		if ($count == $last_report_count){
			$current_trend = 'FLAT';	
		}elseif ($count > $last_report_count){
			$current_trend = 'UP';	
		}else{
			$current_trend = 'DOWN';
		}
		if ($last_trend_direction == $current_trend){
			$current_duration = $last_trend_duration + 1;
		}else{
			$current_duration = 0;
		}
	}else{
		// we reached the start of data collection.	
	}
	$county_name = cleanup_county($county_name);
	$county_name = $covid_db->real_escape_string($county_name);
	if ($d['id'] == ''){
		echo "[insert $Resident_Type $Facility_Name $count $date]";
		$q = "insert into coronavirus_facility (county_name,Resident_Type,zip_code,Facility_Name,report_date,report_count,state_name,trend_direction,trend_duration,Number_of_Resident_Cases,Number_of_Staff_Cases,Number_of_Resident_Deaths,Number_of_Staff_Deaths) values ('$county_name','$Resident_Type','$zip','$Facility_Name','$date','$count','Maryland','$current_trend','$current_duration','$Number_of_Resident_Cases','$Number_of_Staff_Cases','$Number_of_Resident_Deaths','$Number_of_Staff_Deaths') ";
	}else{
		echo "[update $Resident_Type $Facility_Name $count $date]";
		$q = "update coronavirus_facility set county_name='$county_name',Resident_Type='$Resident_Type',Number_of_Resident_Cases='$Number_of_Resident_Cases', Number_of_Staff_Cases='$Number_of_Staff_Cases', Number_of_Resident_Deaths='$Number_of_Resident_Deaths',Number_of_Staff_Deaths='$Number_of_Staff_Deaths', zip_code = '$zip', report_count = '$count', trend_direction = '$current_trend', trend_duration = '$current_duration'  where Facility_Name = '$Facility_Name' and report_date = '$date' ";
		
	}
	$covid_db->query($q);
	//slack_general("$q",'covid19-sql');
	//slack_general(mysqli_error($covid_db),'covid19-sql');

}


$master_array = array();

ob_start();
$q = "select * from coronavirus_apis where run_order = '5000' "; // MD Facilities
$r = $covid_db->query($q);
while ($d = mysqli_fetch_array($r)){
	if ($_GET['date']){
  		$q2 = "select * from coronavirus_api_cache where api_id = '$d[id]' and cache_date_time like '$_GET[date] %' order by id desc limit 0,1 ";
	}else{
		$q2 = "select * from coronavirus_api_cache where api_id = '$d[id]' order by id desc limit 0,1 ";
	}
	echo "<h3>$q2</h3>";
  $r2 = $covid_db->query($q2);
  $d2 = mysqli_fetch_array($r2);
  echo "<h1>$d[api_name] from $d2[cache_date_time]</h1>";
  $api_name = cleanup($d['api_name']);
  $json = $d2['raw_response'];
  $array = json_decode($json, true);
  foreach ($array['features'] as $key => $value){
    	  $Facility_Name = cleanup($value['attributes']['FACILITY_NAME']);
    	  //$master_array[$Facility_Name] = $value['attributes']['FACILITY_NAME']; 
	  $time = $value['attributes']['DATE'] / 1000;
	  $date = date('Y-m-d',$time+14400);
	  $master_array[$Facility_Name]['DATE'] = $date;
	  $master_array[$Facility_Name]['Name'] = $Facility_Name;
	  $master_array[$Facility_Name]['Zip'] = $Facility_ZIP[$Facility_Name];
	  $master_array[$Facility_Name]['COUNTY'] = $value['attributes']['COUNTY'];
	  $master_array[$Facility_Name]['Resident_Type'] = 'Assisted';
	  if ($value['attributes']['Youth_Public'] > 0){
	  	$master_array[$Facility_Name]['Resident_Type'] = 'Youth';
	  }
	  if ($value['attributes']['Inmates_Public'] > 0){
	  	$master_array[$Facility_Name]['Resident_Type'] = 'Inmate';
	  }
	  if ($value['attributes']['Patients_Public'] > 0){
	  	$master_array[$Facility_Name]['Resident_Type'] = 'Patient';
	  }

	  
	  //if ($api_name == 'MDCongregate_COVID19_Assisted'){
		$master_array[$Facility_Name]['Total_Cases'] = $value['attributes']['Staff_Private']+$value['attributes']['Residents_Private']+$value['attributes']['Staff_Public']+$value['attributes']['Patients_Public']+$value['attributes']['Inmates_Public']+$value['attributes']['Youth_Public'];  	  
		$master_array[$Facility_Name]['Number_of_Resident_Cases'] = $value['attributes']['Residents_Private']+$value['attributes']['Patients_Public']+$value['attributes']['Inmates_Public']+$value['attributes']['Youth_Public'];  	  
	  	$master_array[$Facility_Name]['Number_of_Staff_Cases'] = $value['attributes']['Staff_Private']+$value['attributes']['Staff_Public'];  	  
	 // }
	  //if ($api_name == 'MDCOVID19_NumberofDeathsByAffected'){
		$master_array[$Facility_Name]['Total_Deaths'] = $value['attributes']['Staff_Private']+$value['attributes']['Residents_Private']+$value['attributes']['Staff_Public']+$value['attributes']['Patients_Public']+$value['attributes']['Inmates_Public']+$value['attributes']['Youth_Public'];  	  
		$master_array[$Facility_Name]['Number_of_Resident_Deaths'] = $value['attributes']['Residents_Private']+$value['attributes']['Patients_Public']+$value['attributes']['Inmates_Public']+$value['attributes']['Youth_Public'];  	  
	  	$master_array[$Facility_Name]['Number_of_Staff_Deaths'] = $value['attributes']['Staff_Private']+$value['attributes']['Staff_Public'];  	  
	 // }
	  // a
	  //$master_array[$Facility_Name][$api_name.'_Staff_Private'] = $value['attributes']['Staff_Private'];
	  //$master_array[$Facility_Name][$api_name.'_Residents_Private'] = $value['attributes']['Residents_Private'];
	  //$master_array[$Facility_Name][$api_name.'_Staff_Public'] = $value['attributes']['Staff_Public'];
	  // b
	  //$master_array[$Facility_Name][$api_name.'_Patients_Public'] = $value['attributes']['Patients_Public'];
	  // c
	  //$master_array[$Facility_Name][$api_name.'_Inmates_Public'] = $value['attributes']['Inmates_Public'];
	  // d
	  //$master_array[$Facility_Name][$api_name.'_Youth_Public'] = $value['attributes']['Youth_Public'];
	  
	  
	 
		  
 	  
		  
	  //echo "<li>$Facility_Name $api_name Staff_Private ".$value['attributes']['Staff_Private']."</li>";
    echo "<pre>";
    print_r($value);
    echo "</pre>";
  }
  
}
$buffer=ob_get_clean();


foreach ($master_array as $Facility => $Data){
	// basic
	echo "<li>coronavirus_Facility($Data[Name],$Data[Zip],$Data[DATE],$Data[Total_Cases],$Data[Number_of_Resident_Cases],$Data[Number_of_Staff_Cases],$Data[Number_of_Resident_Deaths],$Data[Number_of_Staff_Deaths],$Data[Resident_Type])</li>";
	//coronavirus_Facility($Data['Name'],$Data['Zip'],$Data['DATE'],$Data['Total_Cases'],$Data['Number_of_Resident_Cases'],$Data['Number_of_Staff_Cases'],$Data['Number_of_Resident_Deaths'],$Data['Number_of_Staff_Deaths'],$Data['Resident_Type'],$Data['COUNTY']);
}



echo "<pre>";
print_r($master_array);
echo "</pre>";


echo $buffer;


include_once('../footer.php');
