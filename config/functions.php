<?php

require_once "env.php";
define('COMPOSER_AUTOLOAD', '../composer/vendor/autoload.php');
define('PREFER_RETURN', 'return=minimal');
define('FORMAT', '/[^a-zA-Z0-9]/');

function baseUri($endpoint = '')
{

    $cleanEndpoint = basename($endpoint);
    return $_ENV['SUPABASE_URL'] . '/auth/v1/' . $cleanEndpoint;
}

function getHeader()
{
    return [
        'apikey' => $_ENV['SUPABASE_DEFAULT_KEY'],
        'Content-Type' => 'application/json'
    ];
}

function supabaseRequest($endpoint)
{

    $cleanEndpoint = basename($endpoint);
    $url = $_ENV['SUPABASE_URL'] . '/rest/v1/' . $cleanEndpoint;

    $headers = [
        "apikey: " . $_ENV['SUPABASE_DEFAULT_KEY'],
        "Authorization: Bearer " . $_ENV['SUPABASE_DEFAULT_KEY'],
        "Content-Type: application/json"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function supabaseCreatePhotoPainting($bucket, $table, $id_user)
{
    require_once COMPOSER_AUTOLOAD;


    $url = $_ENV['SUPABASE_URL'];
    $api_key = $_ENV['SUPABASE_SERVICE_ROLE'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $file = $_FILES['imagem'];
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $ano = $_POST['ano'];
        $id_usuario = $id_user;

        if ($file['error'] === 0) {

            $client = new GuzzleHttp\Client();

            $extension = preg_replace(FORMAT, '', pathinfo($file['name'], PATHINFO_EXTENSION));
            $fileName = uniqid('img_', true) . '.' . $extension;


            $client->post(
                "$url/storage/v1/object/$bucket/$fileName",
                [
                    'headers' => [
                        'apikey' => $api_key,
                        'Authorization' => "Bearer $api_key",
                        'Content-Type' => $file['type']
                    ],
                    'body' => fopen($file['tmp_name'], 'r')
                ]
            );


            $publicUrl = "$url/storage/v1/object/public/$bucket/$fileName";


            $client->post(
                "$url/rest/v1/$table",
                [
                    'headers' => [
                        'apikey' => $api_key,
                        'Authorization' => "Bearer $api_key",
                        'Prefer' => PREFER_RETURN
                    ],
                    'json' => [
                        'titulo' => $titulo,
                        'autor' => $autor,
                        'ano' => $ano,
                        'url' => $publicUrl,
                        'id_usuario' => $id_usuario
                    ]
                ]
            );
            echo "<script>alert('Mídia submetida!');</script>";
        }
    }
}

function supabaseCreateBook($id_user)
{
    require_once COMPOSER_AUTOLOAD;

    $url = $_ENV['SUPABASE_URL'];
    $api_key = $_ENV['SUPABASE_SERVICE_ROLE'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $file = $_FILES['imagem'];
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $ano = $_POST['ano'];
        $cc0 = $_POST['cc0'];
        $id_usuario = $id_user;

        if ($file['error'] === UPLOAD_ERR_OK || $file['error'] === UPLOAD_ERR_NO_FILE) {

            $client = new GuzzleHttp\Client();

            if ($file['error'] === UPLOAD_ERR_OK) {

                $extension = preg_replace(FORMAT, '', pathinfo($file['name'], PATHINFO_EXTENSION));
                $fileName = uniqid('img_', true) . '.' . $extension;


                $client->post(
                    "$url/storage/v1/object/Biblioteca/CapasImagem/$fileName",
                    [
                        'headers' => [
                            'apikey' => $api_key,
                            'Authorization' => "Bearer $api_key",
                            'Content-Type' => $file['type']
                        ],
                        'body' => fopen($file['tmp_name'], 'r')
                    ]
                );
                $publicUrlImage = "$url/storage/v1/object/public/Biblioteca/CapasImagem/$fileName";
            } else {
                $publicUrlImage = "$url/storage/v1/object/public/Biblioteca/CapasImagem/semcapa.jpg";
            }

            if ($cc0 == "True") {
                $link = $_FILES['link'];
                $extension = preg_replace(FORMAT, '', pathinfo($link['name'], PATHINFO_EXTENSION));
                $fileName = uniqid('pdf', true) . '.' . $extension;


                $client->post(
                    "$url/storage/v1/object/Biblioteca/pdfscc0/$fileName",
                    [
                        'headers' => [
                            'apikey' => $api_key,
                            'Authorization' => "Bearer $api_key",
                            'Content-Type' => $link['type']
                        ],
                        'body' => file_get_contents($link['tmp_name'])
                    ]
                );
                $linkTratado = "$url/storage/v1/object/public/Biblioteca/pdfscc0/$fileName";
            } else {
                $link = $_POST['link'];
                $linkTratado = $link;
            }

            $client->post(
                "$url/rest/v1/livros",
                [
                    'headers' => [
                        'apikey' => $api_key,
                        'Authorization' => "Bearer $api_key",
                        'Prefer' => PREFER_RETURN
                    ],
                    'json' => [
                        'titulo' => $titulo,
                        'autor' => $autor,
                        'ano' => $ano,
                        'url' => $publicUrlImage,
                        'link' => $linkTratado,
                        'cc0' => $cc0,
                        'id_usuario' => $id_usuario
                    ]
                ]
            );
            echo "<script>alert('Obra submetida!');</script>";
        }
    }
}

function supabaseCreateFilm($id_user)
{
    require_once COMPOSER_AUTOLOAD;
    $url = $_ENV['SUPABASE_URL'];
    $api_key = $_ENV['SUPABASE_SERVICE_ROLE'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $file = $_FILES['imagem'];
        $link = $_POST['link'];
        $titulo = $_POST['titulo'];
        $desc = $_POST['desc'];
        $tipomidia = $_POST['tipomidia'] ?? '';
        $id_usuario = $id_user;

        $tiposPermitidos = [
            'curtas',
            'filmes',
            'desenhos',
            'documentarios',
            'series',
            'biografias',
            'clipes'
        ];

        if (!in_array($tipomidia, $tiposPermitidos, true)) {
            die('Tipo de mídia inválido.');
        } else {
            $tipomidiatratado = urlencode($tiposPermitidos[$tipomidia]);
        }

        $bucket = 'Filmes/' . basename($tipomidiatratado);

        if ($file === null || $file['error'] !== UPLOAD_ERR_OK) {
            die('Arquivo inválido.');
        }

        if ($file['error'] === 0) {

            $client = new GuzzleHttp\Client();

            $extension = preg_replace(FORMAT, '', pathinfo($file['name'], PATHINFO_EXTENSION));
            $fileName = uniqid('mov_', true) . '.' . $extension;

            $client->post(
                "$url/storage/v1/object/$bucket/$fileName",
                [
                    'headers' => [
                        'apikey' => $api_key,
                        'Authorization' => "Bearer $api_key",
                        'Content-Type' => $file['type']
                    ],
                    'body' => fopen($file['tmp_name'], 'r')
                ]
            );


            $publicUrl = "$url/storage/v1/object/public/$bucket/$fileName";


            $client->post(
                "$url/rest/v1/filmes",
                [
                    'headers' => [
                        'apikey' => $api_key,
                        'Authorization' => "Bearer $api_key",
                        'Content-Type' => 'application/json',
                        'Prefer' => PREFER_RETURN
                    ],
                    'json' => [
                        'titulo' => $titulo,
                        'desc' => $desc,
                        'link' => $link,
                        'url' => $publicUrl,
                        'tipo' => $tipomidia,
                        'id_usuario' => $id_usuario
                    ]
                ]
            );
            echo "<script>alert('Mídia submetida!');</script>";
        }
    }
}

function getUserAdm($user_id, $token)
{
    require_once COMPOSER_AUTOLOAD;
    $client = new GuzzleHttp\Client();

    $url = $_ENV['SUPABASE_URL'];
    $url = $url . '/rest/v1/usuarios?id_usuario=eq.' . urlencode($user_id);

    try {
        $response = $client->get($url, [
            'headers' => [
                'apikey' => $_ENV['SUPABASE_SERVICE_ROLE'],
                'Authorization' => 'Bearer ' . $token
            ]
        ]);

        $data = json_decode($response->getBody());

        if (!empty($data) && isset($data[0]->adm)) {
            return (bool) $data[0]->adm;
        }

        return false;
    } catch (Exception $e) {
        echo 'Erro: ' . $e->getMessage();
        exit;
    }
}

function getUserId($user_id, $token)
{
    require_once COMPOSER_AUTOLOAD;
    $client = new GuzzleHttp\Client();

    $url = $_ENV['SUPABASE_URL'];
    $url = $url . '/rest/v1/usuarios?id_usuario=eq.' . urlencode($user_id);

    try {
        $response = $client->get($url, [
            'headers' => [
                'apikey' => $_ENV['SUPABASE_SERVICE_ROLE'],
                'Authorization' => 'Bearer ' . $token
            ]
        ]);

        $data = json_decode($response->getBody());

        if (!empty($data) && isset($data[0]->id)) {
            return (int) $data[0]->id;
        }

        return false;
    } catch (Exception $e) {
        echo 'Erro: ' . $e->getMessage();
        exit;
    }
}

function supabaseDeleteItem($tabela)
{
    require_once COMPOSER_AUTOLOAD;

    $id = $_POST['id'];
    $url = $_ENV['SUPABASE_URL'];
    $api_key = $_ENV['SUPABASE_SERVICE_ROLE'];

    $client = new GuzzleHttp\Client();

    $client->delete(
        "$url/rest/v1/$tabela?id=eq.$id",
        [
            'headers' => [
                'apikey' => $api_key,
                'Authorization' => "Bearer $api_key",
                'Prefer' => PREFER_RETURN
            ]
        ]
    );
    echo "<script>alert('Item apagado!');</script>";
}

function supabaseUpdatePhotoPaintingBook($table)
{
    require_once COMPOSER_AUTOLOAD;

    $url = $_ENV['SUPABASE_URL'];
    $api_key = $_ENV['SUPABASE_SERVICE_ROLE'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $ano = $_POST['ano'];

        $client = new GuzzleHttp\Client();

        $client->patch(
            "$url/rest/v1/$table?id=eq.$id",
            [
                'headers' => [
                    'apikey' => $api_key,
                    'Authorization' => "Bearer $api_key",
                    'Prefer' => PREFER_RETURN
                ],
                'json' => [
                    'titulo' => $titulo,
                    'autor' => $autor,
                    'ano' => $ano
                ]
            ]
        );

        echo "<script>alert('Mídia atualizada!');</script>";
    }
}

function supabaseUpdateFilm()
{
    require_once COMPOSER_AUTOLOAD;

    $url = $_ENV['SUPABASE_URL'];
    $api_key = $_ENV['SUPABASE_SERVICE_ROLE'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'];
        $link = $_POST['link'];
        $titulo = $_POST['titulo'];
        $desc = $_POST['desc'];
        $tipomidia = $_POST['tipomidia'];

        $tiposPermitidos = [
            'curtas',
            'filmes',
            'desenhos',
            'documentarios',
            'series',
            'biografias',
            'clipes'
        ];

        if (!in_array($tipomidia, $tiposPermitidos)) {
            die('Tipo de mídia inválido.');
        }

        $client = new GuzzleHttp\Client();

        $client->patch(
            "$url/rest/v1/filmes?id=eq.$id",
            [
                'headers' => [
                    'apikey' => $api_key,
                    'Authorization' => "Bearer $api_key",
                    'Prefer' => PREFER_RETURN
                ],
                'json' => [
                    'titulo' => $titulo,
                    'desc' => $desc,
                    'link' => $link,
                    'tipo' => $tipomidia
                ]
            ]
        );

        echo "<script>alert('Mídia atualizada!');</script>";
    }
}

function supabaseCreateTerm($id_user)
{
    require_once COMPOSER_AUTOLOAD;

    $url = $_ENV['SUPABASE_URL'];
    $api_key = $_ENV['SUPABASE_SERVICE_ROLE'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $link = $_FILES['link'];
        $autor = $_POST['autor'];
        $id_usuario = $id_user;

        if ($link['error'] === UPLOAD_ERR_OK || $link['error'] === UPLOAD_ERR_NO_FILE) {

            $client = new GuzzleHttp\Client();

            $extension = preg_replace(
                FORMAT,
                '',
                pathinfo($link['name'], PATHINFO_EXTENSION)
            );

            $fileName = uniqid('pdf', true) . '.' . $extension;

            $client->post(
                "$url/storage/v1/object/Termos/$fileName",
                [
                    'headers' => [
                        'apikey' => $api_key,
                        'Authorization' => "Bearer $api_key",
                        'Content-Type' => $link['type']
                    ],
                    'body' => file_get_contents($link['tmp_name'])
                ]
            );

            $linkTratado = "$url/storage/v1/object/public/Termos/$fileName";

            $client->post(
                "$url/rest/v1/termos_uso",
                [
                    'headers' => [
                        'apikey' => $api_key,
                        'Authorization' => "Bearer $api_key",
                        'Prefer' => PREFER_RETURN
                    ],
                    'json' => [
                        'autor' => $autor,
                        'link' => $linkTratado,
                        'id_usuario' => $id_usuario
                    ]
                ]
            );

            echo "<script>alert('Termo submetido!');</script>";
        }
    }
}

function supabaseCreateLegislation($id_user)
{
    require_once COMPOSER_AUTOLOAD;

    $url = $_ENV['SUPABASE_URL'];
    $api_key = $_ENV['SUPABASE_SERVICE_ROLE'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $titulo = $_POST['titulo'];
        $norma = $_POST['norma'];
        $data = $_POST['data'];
        $link = $_POST['link'];
        $id_usuario = $id_user;

        $client = new GuzzleHttp\Client();

        $client->post(
            "$url/rest/v1/legislacao",
            [
                'headers' => [
                    'apikey' => $api_key,
                    'Authorization' => "Bearer $api_key",
                    'Prefer' => PREFER_RETURN
                ],
                'json' => [
                    'titulo' => $titulo,
                    'norma' => $norma,
                    'data' => $data,
                    'link' => $link,
                    'id_usuario' => $id_usuario
                ]
            ]
        );

        echo "<script>alert('Legislação submetida!');</script>";
    }
}

function supabaseUpdateLegislation()
{
    require_once COMPOSER_AUTOLOAD;

    $url = $_ENV['SUPABASE_URL'];
    $api_key = $_ENV['SUPABASE_SERVICE_ROLE'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $norma = $_POST['norma'];
        $data = $_POST['data'];
        $link = $_POST['link'];

        $client = new GuzzleHttp\Client();

        $client->patch(
            "$url/rest/v1/legislacao?id=eq.$id",
            [
                'headers' => [
                    'apikey' => $api_key,
                    'Authorization' => "Bearer $api_key",
                    'Prefer' => PREFER_RETURN
                ],
                'json' => [
                    'titulo' => $titulo,
                    'norma' => $norma,
                    'data' => $data,
                    'link' => $link
                ]
            ]
        );

        echo "<script>alert('Legislação atualizada!');</script>";
    }
}
