<?php
/**
 * Change upload directory for PDF files 
 */
add_filter('wp_handle_upload_prefilter', 'pdfnar_pre_upload');
add_filter('wp_handle_upload', 'pdfnar_post_upload');

function pdfnar_pre_upload($file){
    add_filter('upload_dir', 'pdfnar_custom_upload_dir');
    return $file;
}

function pdfnar_post_upload($fileinfo){
    remove_filter('upload_dir', 'pdfnar_custom_upload_dir');
    return $fileinfo;
}

function pdfnar_custom_upload_dir($path){    
    $extension = substr(strrchr($_POST['name'],'.'),1);
    if(!empty($path['error']) ||  $extension != 'pdf') { return $path; } //error or other filetype; do nothing. 
    $customdir = '/pdf';
    $path['path']    = str_replace($path['subdir'], '', $path['path']); //remove default subdir (year/month)
    $path['url']     = str_replace($path['subdir'], '', $path['url']);      
    $path['subdir']  = $customdir;
    $path['path']   .= $customdir; 
    $path['url']    .= $customdir;  
    return $path;
}