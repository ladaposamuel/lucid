<?php


$router->get('/api/images', function() {
    return (new App\Core\UploadImage)->getAllImages();
});
  
$router->post('/api/upload-image', function() {
    return (new App\Core\UploadImage)->upload();
});
  

