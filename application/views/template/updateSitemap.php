 <?php
    $input = '';
    $input .= '<?xml version="1.0" encoding="utf-8"?>';
    $input .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

    foreach ($this->db->get('chb_urls')->result_array() as $url) {
        $input .= '<url> <loc>' . $url['url'] . '</loc>  <changefreq>always</changefreq> <priority>1.0</priority>  </url>';
    }
    $input .= '</urlset>';
    $xmlFile = fopen("./sitemap.xml", "w") or die("Unable to open file!");
    fwrite($xmlFile, $input);
    fclose($xmlFile);
?> 


<?php
    if (!$this->session->userdata('chbUserAuth')) {
        redirect(base_url().'login');
    } 
?>

