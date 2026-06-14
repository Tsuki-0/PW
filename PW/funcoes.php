<?php
function redimensionarImagem($origem, $destino, $larguraMax = 300) {
    $info = getimagesize($origem);
    if (!$info) {
        throw new Exception("Não foi possível ler a imagem.");
    }

    $largura = $info[0];
    $altura  = $info[1];
    $tipo    = $info[2];

    // Se a imagem já for menor que o limite, só copia
    if ($largura <= $larguraMax) {
        copy($origem, $destino);
        return;
    }

    $ratio    = $larguraMax / $largura;
    $novaLarg = $larguraMax;
    $novaAlt  = (int)($altura * $ratio);

    $nova = imagecreatetruecolor($novaLarg, $novaAlt);

    if ($tipo === IMAGETYPE_JPEG) {
        $src = imagecreatefromjpeg($origem);
    } elseif ($tipo === IMAGETYPE_PNG) {
        // Preserva transparência no PNG
        imagealphablending($nova, false);
        imagesavealpha($nova, true);
        $src = imagecreatefrompng($origem);
    } elseif ($tipo === IMAGETYPE_WEBP) {
        $src = imagecreatefromwebp($origem);
    } elseif ($tipo === IMAGETYPE_GIF) {
        $src = imagecreatefromgif($origem);
    } else {
        throw new Exception("Formato de imagem não suportado. Use JPG, PNG, WEBP ou GIF.");
    }

    imagecopyresampled($nova, $src, 0, 0, 0, 0, $novaLarg, $novaAlt, $largura, $altura);

    if ($tipo === IMAGETYPE_JPEG) {
        imagejpeg($nova, $destino, 85);
    } elseif ($tipo === IMAGETYPE_PNG) {
        imagepng($nova, $destino, 6);
    } elseif ($tipo === IMAGETYPE_WEBP) {
        imagewebp($nova, $destino, 85);
    } elseif ($tipo === IMAGETYPE_GIF) {
        imagegif($nova, $destino);
    }

imagedestroy($src);
    imagedestroy($nova);
}