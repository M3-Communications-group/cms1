<?php

$tables = array('');

$admin_menu = array(
);

$arr_allow_file_types = array(
    "gif" => "image/gif",
    "png" => "image/gif",
    "jpg" => "image/jpeg",
    "jpeg" => "image/jpeg",
    "tif" => "image/tiff",
    "tiff" => "image/tiff",
    "psd" => "image/x-photoshop",
    "ai" => "application/postscript",
    "eps" => "application/postscript",
    "cdr" => "image/x-coreldraw",
    "swf" => "application/x-shockwave-flash",
    "mp3" => "audio/mpeg",
    "wav" => "audio/x-wav",
    "mpg" => "video/mpeg",
    "mpeg" => "video/mpeg",
    "mp4" => "video/mp4",
    "rm" => "audio/x-pn-realaudio",
    "avi" => "video/x-msvideo",
    "mov" => "video/quicktime",
    "wmv" => "video/x-ms-wmv",
    "doc" => "application/msword",
    "docx" => "application/msword",
    "rtf" => "application/rtf",
    "xls" => "application/vnd.ms-excel",
    "xlsx" => "application/vnd.ms-excel",
    "pdf" => "application/pdf",
    "ppt" => "application/vnd.ms-powerpoint",
    "pptx" => "application/vnd.ms-powerpoint",
    "pps" => "application/vnd.ms-powerpoint",
    "txt" => "text/plain",
    "zip" => "application/zip",
    "flv" => "video/x-flv",
);



$die_string = '<br><br><a href="javascript:history.go(-1)">Go back</a>';

$mysearch = array(
    0 => '/' . chr(226) . chr(128) . chr(147) . '/',
    1 => '/' . chr(226) . chr(128) . chr(153) . '/',
    2 => '/' . chr(226) . chr(128) . chr(156) . '/',
    3 => '/' . chr(226) . chr(128) . chr(157) . '/',
    4 => '/' . chr(226) . chr(128) . chr(166) . '/',
    5 => '/’/',
    6 => '/“/',
    7 => '/”/',
    8 => '/–/',
    9 => '/—/',
    10 => '/…/',
    11 => '/-/',
    12 => '/’/',
);
$myreplace = array(
    0 => '-',
    1 => "\\'",
    2 => '"',
    3 => '"',
    4 => '...',
    5 => "\'",
    6 => '\"',
    7 => '\"',
    8 => '-',
    9 => '-',
    10 => '...',
    11 => '-',
    12 => "\\'",
);

$admin_texts['bg']["edit"] = "Редактиране";
$admin_texts['bg']["add"] = "Добавяне";
$admin_texts['bg']["view"] = "Списък";
$admin_texts['bg']["list"] = "Списък";
$admin_texts['bg']["total"] = "Общо";
$admin_texts['bg']["select"] = "Избери";
$admin_texts['bg']["delete"] = "изтрий";
$admin_texts['bg']["delete_image"] = "Изтрий снимката";
$admin_texts['bg']["is_required"] = " е задължително";
$admin_texts['bg']["is_unique"] = "трябва да е уникално, вече съществува";
$admin_texts['bg']["is_invalid"] = "Невалидно съдържание в";
$admin_texts['bg']["is_invalid_email"] = "Невалиден e-mail в поле";
$admin_texts['bg']["is_invalid_format"] = "Невалиден формат на";
$admin_texts['bg']["is_mkdir"] = "Необходимата директория не може да бъде създадена. Обадете се на Миленище или изпълнете mkdir";
$admin_texts['bg']["is_big"] = "е много голям. Позволено е максимум";
$admin_texts['bg']["width_of"] = "Ширината на";
$admin_texts['bg']["height_of"] = "Височината на";
$admin_texts['bg']["propotion_of"] = "Пропорцията на";
$admin_texts['bg']["has_to"] = "трябва да бъде";
$admin_texts['bg']["not"] = "не";
$admin_texts['bg']["maximum"] = "максимум";
$admin_texts['bg']["minimum"] = "минимум";
$admin_texts['bg']["save"] = "Запиши";
$admin_texts['bg']["success"] = "Операцията е успешна!";
$admin_texts['bg']["archive_open_failed"] = "файлът не може фа бъде отворен!";
$admin_texts['bg']["password_wong_old"] = "Грешна стара парола.";
$admin_texts['bg']["password_invalid_symbols"] = "Невалидни символи в новата парола.";
$admin_texts['bg']["password_min8"] = "Новата парола трябва да е поне 8 символа.";
$admin_texts['bg']["password_one_number"] = "В паролата трбва да има поне едно число.";
$admin_texts['bg']["password_one_small_letter"] = "В паролата трябва да има поне една малка буква.";
$admin_texts['bg']["password_one_big_letter"] = "В паролата трябва да има поне една голяма буква.";
$admin_texts['bg']["passwords_dont_match"] = "Двете пароли не съвпадат.";
$admin_texts['bg']["password_changed"] = "Паролата е сменена успешно!";
$admin_texts['bg']["password_old"] = "Стара парола";
$admin_texts['bg']["password_new"] = "Нова парола";
$admin_texts['bg']["password_repeat"] = "Отново паролата";
$admin_texts['bg']["change"] = "Смени";

$admin_texts['en']["edit"] = "Edit";
$admin_texts['en']["add"] = "Add";
$admin_texts['en']["view"] = "List";
$admin_texts['en']["list"] = "List";
$admin_texts['en']["total"] = "Total";
$admin_texts['en']["select"] = "Select";
$admin_texts['en']["delete"] = "delete";
$admin_texts['en']["delete_image"] = "Delete Image";
$admin_texts['en']["is_required"] = " is required";
$admin_texts['en']["is_unique"] = "needs to have unique value, this value already exists in the database: ";
$admin_texts['en']["is_invalid"] = "Invalid content in";
$admin_texts['en']["is_invalid_email"] = "Invalid e-mail address in field";
$admin_texts['en']["is_invalid_format"] = "Invalid format of";
$admin_texts['en']["is_mkdir"] = "The needed folder can't be automatically created. Please call Administrator or mkdir";
$admin_texts['en']["is_big"] = "is too big. Maximum allowed size is ";
$admin_texts['en']["width_of"] = "Width of";
$admin_texts['en']["height_of"] = "Height of";
$admin_texts['en']["propotion_of"] = "Propotion of";
$admin_texts['en']["has_to"] = "has to be";
$admin_texts['en']["not"] = "not";
$admin_texts['en']["maximum"] = "maximum";
$admin_texts['en']["minimum"] = "minimum";
$admin_texts['en']["save"] = "Save";
$admin_texts['en']["success"] = "Operation successfull!";
$admin_texts['en']["archive_open_failed"] = "file cannot be opened!";
$admin_texts['en']["password_wong_old"] = "Wrong old password.";
$admin_texts['en']["password_invalid_symbols"] = "Invalid symbols in the new password.";
$admin_texts['en']["password_min8"] = "The new password must be at least 8 symbols.";
$admin_texts['en']["password_one_number"] = "You should have at least one number in the password.";
$admin_texts['en']["password_one_small_letter"] = "You should have at least one small letter in the password.";
$admin_texts['en']["password_one_big_letter"] = "You should have at least one capital letter in the password.";
$admin_texts['en']["passwords_dont_match"] = "The two passwords don't match.";
$admin_texts['en']["password_changed"] = "The password is successfully changed!";
$admin_texts['en']["password_old"] = "Old password";
$admin_texts['en']["password_new"] = "New password";
$admin_texts['en']["password_repeat"] = "Confirm new password";
$admin_texts['en']["change"] = "Change";

