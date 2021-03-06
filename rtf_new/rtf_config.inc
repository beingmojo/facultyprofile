<?
//    CONFIGURATION FILE FOR RTF GENERATOR CLASS
//    SOME OF THESE SETTINGS COULD BE OVERWRITTEN BY USING SPECIAL TAGS
//    IN CASE OF OMMITTING THE TAGS, TEXT IS FORMATTED USING THESE SETTINGS

/////
// ATTENTION!
// all measurements are given in millemeters, but you can use the following units:
//  'cm'   : //centimeters 
//  'mm'   : //millimeters 
//  'q'    : //alias of 'kyu'
//  'kyu'  : //Q/kyu 
//  'in'   : //inches
//  'pt'   : //alias of 'pts' (points)
//  'pts'  : //points
//  'picas': //picas 
//  'twips': //twips 
/////

// ALSO - you can set special units everywhere, example:
//  $pg_height="12in"; // will mean 12 inches
//  <table width=2cm> // will set table width to 2 cm
// and alike.


$default_units = "mm"; // default measurement units 

//---------------------------------------------------
// DEFAULT PAGE SETTINGS
//---------------------------------------------------
$pg_width=210; // page width (mm)
$pg_height=297; // page height (mm)
$mar_left=10; // left margin width (mm)
$mar_right=10; // right margin width (mm)
$mar_top=15; // top margin height (mm)
$mar_bott=19; // bottom margin height (mm)

$facing_pages = 0; // 1 - activates activates odd/even headers and gutters;
                   // 0 - deactivates
$gutter_width = 30; // Gutter width (when $facing_pages is activated)
$rtl_gutter = 0; // if 1 - Gutter is positioned on the right


$page_orientation = "portrait"; // portrait or landscape
//$page_orientation = "landscape"; // portrait or landscape

$header_align = "center"; // default header align - "left", "right", "center"
$footer_align = "left"; // default footer align - "left", "right", "center"
$head_y=12; // space between the top edge of the page and the top header (mm)
$foot_y=12; // space between the bottom edge of the page and the bottom footer (mm)

$page_numbers = 1; // page numbers, if  < 0 - no page numbers; if >= 0 page numbers start from the specified number
$page_numbers_valign = "bottom"; // vertical alignment of the page numbers ("top" or "bottom")
$page_numbers_align = "center"; // horisontal alignment of the page numbers ("left", "center", "right")

$page_numbers_autoinsert = "0"; // 0 = disable, 1 = enable autoinsertion. 
                                // Use <cpagenum> to insert pagenumber when disabled. 
                                // Valign and align only work in enabled mode


//---------------------------------------------------
// DEFAULT HYPER LINK SETTINGS
//---------------------------------------------------
$h_link_color = "#0000FF"; // default color for hyper links
$h_link_fontf = "garamond"; // default link font face [arial,roman,sym,courier,seriff,garamond]
$h_link_fonts = "12"; // default link font size in pt
$h_link_fontd = "i"; // default link decoration [ul - underline, i - italic, b - old]

//---------------------------------------------------
// DEFAULT FONT AND PARAGRAPH SETTINGS
//---------------------------------------------------

$font_face = "arial"; // default font face [arial,roman,sym,courier,seriff,garamond]
$font_size = "10";  // font size in pt
$def_par_before = "0"; // space before paragraph (mm) (better set to 0, when using tables and set by tag)
$def_par_after = "0"; // space after paragraph (mm) (better set to 0, when using tables and set by tag)
$def_par_align = "left"; // default paragraph align. 
                                     // "left", "right", "center", "justify"

$def_par_lines = 0; // space between lines (mm). if 0 - minimal is taken
$def_par_lindent = "0"; // paragraph left indent (mm) (better set by tag)
$def_par_rindent = "0"; // paragraph right indent (mm) (better set by tag)
$def_par_findent = "0"; // first line indent (mm) (better set by tag)

//---------------------------------------------------
// DEFAULT TABLE SETTINGS
//---------------------------------------------------
$tbl_def_border = 1; // table border (1 - yes; 0 - no) or string value:
                     //   "t,b,r,l" - means: top,bottom,right,left borders
                     //   you can vary these letters to get the result you need
$tbl_def_width = "100%"; // table width (in mm or in % from page width)
$tbl_def_cellpadding = 0; // default cellpadding (mm)
$tbl_def_align = "left"; // default table align on the page (center, right, left)
$tbl_def_valign = "top";// default vertical text align for all the cells (top, middle, bottom)
$tbl_def_bgcolor = "0"; // table background (0 - no, or % from black)
$row_def_align = "left"; // default horizontal text align for all the cells (center, right, left)

//---------------------------------------------------
// DEFAULT IMAGE SETTINGS
//---------------------------------------------------
$image_size = 500; // maximum allowed image size in kb

$img_def_border = 0; // image border (1 - yes; 0 - no)
$img_def_src = "http://www.uta.edu/testrsp/profilesystem/images/logo.png";  // default image src (used when no, or a bad source specified)
$img_def_width = 30; // default image width (mm)
$img_def_height = 30; // default image height (mm)
$img_def_left = 0; // space between the anchor and image left edge (mm)
$img_def_top = 0; // space between the anchor and image top edge (mm)
$img_def_space = 5; // space between the image and the text (mm)
$img_def_align = "left"; // image align on the page (center, right, left)
$img_def_wrap = "around"; // type of text wrapping for image (no, updown, around)
$img_def_anchor = "par"; // linking anchor for image
                         // para = image is linked to the current paragraph
                         // page = image is linked to the current page (top left page corner)
                         // margin = image is linked to margin (top left page corner including margins)




////  FONT CHARACTER SET 

//$default_charset = 238; // sets default character set 
$default_charset = 130; // sets default character set 
/*
ANSI                   = 0
Default                = 1
Symbol                 = 2
Invalid                = 3
Mac                    = 77
Shift Jis              = 128
Hangul                 = 129
Johab                  = 130
GB2312                 = 134
Big5                   = 136
Greek                  = 161
Turkish                = 162
Vietnamese             = 163
Hebrew                 = 177
Arabic                 = 178
Arabic Traditional     = 179
Arabic user            = 180
Hebrew user            = 181
Baltic                 = 186
Russian                = 204
Thai                   = 222
238Eastern European    = 238
PC 437                 = 254
OEM                    = 255
*/


?>