<?php

echo view('portada/header');
echo view('portada/contenido', $dataContenido);
echo view('portada/vip', $dataVip);
echo view('portada/sourcequery');
echo view('portada/footer');

?>