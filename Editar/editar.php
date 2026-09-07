<?php
session_start();
if (empty($_SESSION['adm'])) {
    header('Location: index.php');
    exit;
}

require_once '../config/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    match ($_POST['tipo']) {
        'fotografias' => supabaseUpdatePhotoPaintingBook('fotografias'),
        'pinturas' => supabaseUpdatePhotoPaintingBook('pinturas'),
        'filmes' => supabaseUpdateFilm(),
        'livros' => supabaseUpdatePhotoPaintingBook('livros'),
        'legislacao' => supabaseUpdateLegislation(),
        default => null
    };
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../mainStyle/assets/images/FavIcon_SF.png">
    <meta name="description" content="Painel Administrativo ">
    <title>GRIOT - Painel de Edição</title>


    <link rel="stylesheet" href="../mainStyle/assets/fonts/poppins.css">
    <link rel="stylesheet" href="../mainStyle/assets/css/templatemo-space-dynamic.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">


</head>

<body>


    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span><span></span><span></span>
            </div>
        </div>
    </div>


    <header class="header-area">
        <div class="container">
            <nav class="main-nav">
                <div class="left-menu">
                    <button class="menu-trigger" aria-label="Abrir menu"><span></span></button>
                    <ul class="menu-dropdown">
                        <li><a href="../galeria/Fotografias.html">Fotografias</a></li>
                        <li><a href="../biblioteca/Biblioteca.html">Acervo Literário</a></li>
                        <li><a href="../Filmes/Audiovisuais.html">Audiovisuais</a></li>
                        <li><a href="../galeria/Pinturas.html">Pinturas</a></li>
                        <li><a href="../LinhaDoTempo/LinhadoTempo.html">Linha do Tempo</a></li>
                        <li><a href="../Legislacao/Legislacao.html">Legislação</a></li>
                        <li><a href="../Personalidades/Personalidades.html">Personalidades</a></li>
                        <li><a href="../musica/Musica.html"> Músicas</a></li>
                    </ul>
                </div>
                <div class="logo">
                    <a href="../index.php">
                        <img src="../mainStyle/assets/images/LogoEst_SF.png"
                            alt="Logotipo do projeto GRIOT com tipografia colorida e ícone de ave estilizada, com o subtítulo Memória e História Afro-Brasileira">
                    </a>
                </div>
                <div class="right-menu">
                    <a href="../index.php" class="main-red-button">Início</a>
                </div>
            </nav>
        </div>
    </header>



    <section class="banner">
        <h1>Painel Administrativo</h1>
        <p>Gerencie o conteúdo do Museu Virtual GRIOT</p>
        <div class="user-badge">
            👤 <?= htmlspecialchars($_SESSION['email'] ?? 'Administrador') ?>
        </div>
    </section>

    <main class="container">
        <a href="../adm/adm.php">
            <div class="icon-box">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
        </a>
        <h2 class="section-title">Edição de Conteúdo</h2>

        <div class="forms-grid">


            <article class="form-card">
                <h3>Exibir Obras</h3>
                <form method="POST" enctype="multipart/form-data">

                    <label for="secao">Selecione a seção *</label>
                    <select id="secao" name="secao" required>
                        <option value="">Selecione...</option>
                        <option value="pinturas">🎨 Pinturas</option>
                        <option value="fotografias">📷 Fotografias</option>
                        <option value="filmes">🎬 Audiovisuais</option>
                        <option value="livros">📚 Acervo literário</option>
                        <option value="legislacao">⚖️ Legislação</option>
                    </select>

                    <div id="sugestoes"
                        style=" max-height:400px; overflow-y:auto; overflow-x:hidden; background:white; border:2px solid #e5e7eb; border-radius:8px; margin:20px">
                    </div>
                </form>
            </article>

            <article class="form-card">
                <h3>📷 Fotografias</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" value="fotografias">

                    <div class="form-group">
                        <label for="foto_id">ID *</label>
                        <input type="number" id="foto_id" name="id" required placeholder="Ex: 13">
                    </div>

                    <div class="form-group">
                        <label for="foto_titulo">Título *</label>
                        <input type="text" id="foto_titulo" name="titulo" required
                            placeholder="Ex: Retrato da Liberdade">
                    </div>

                    <div class="form-group">
                        <label for="foto_autor">Autor(a) *</label>
                        <input type="text" id="foto_autor" name="autor" required placeholder="Nome do artista">
                    </div>

                    <div class="form-group">
                        <label for="foto_ano">Ano</label>
                        <input type="number" id="foto_ano" name="ano" min="1800" max="2100" placeholder="Ex: 2024">
                    </div>


                    <button type="submit" class="btn-submit">Atualizar Fotografia</button>
                    <p>Adicione uma fotografia por vez.</p>
                </form>
            </article>


            <article class="form-card">
                <h3>🎨 Pinturas</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" value="pinturas">

                    <div class="form-group">
                        <label for="pint_id">ID *</label>
                        <input type="number" id="pint_id" name="id" required placeholder="Ex: 13">
                    </div>

                    <div class="form-group">
                        <label for="pint_titulo">Título *</label>
                        <input type="text" id="pint_titulo" name="titulo" required placeholder="Ex: Raízes Ancestrais">
                    </div>

                    <div class="form-group">
                        <label for="pint_autor">Autor(a) *</label>
                        <input type="text" id="pint_autor" name="autor" required placeholder="Nome do artista">
                    </div>

                    <div class="form-group">
                        <label for="pint_ano">Ano</label>
                        <input type="number" id="pint_ano" name="ano" min="1800" max="2100" placeholder="Ex: 2023">
                    </div>


                    <button type="submit" class="btn-submit">Atualizar Pintura</button>
                    <p>Adicione uma pintura por vez.</p>
                </form>
            </article>


            <article class="form-card">
                <h3>📚 Acervo literário</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" value="livros">

                    <div class="form-group">
                        <label for="capa_id">ID *</label>
                        <input type="number" id="capa_id" name="id" required placeholder="Ex: 13">
                    </div>

                    <div class="form-group">
                        <label for="livros_titulo">Título *</label>
                        <input type="text" id="livros_titulo" name="titulo" required
                            placeholder="Ex: Querido estudante negro">
                    </div>

                    <div class="form-group">
                        <label for="livros_autor">Autor(a) *</label>
                        <input type="text" id="livros_autor" name="autor" required placeholder="Nome do autor">
                    </div>

                    <div class="form-group">
                        <label for="livros_ano">Ano</label>
                        <input type="number" id="livros_ano" name="ano" min="1800" max="2100" placeholder="Ex: 2023">
                    </div>

                    <button type="submit" class="btn-submit">Atualizar Obra</button>
                    <p>Adicione uma obra por vez.</p>
                </form>
            </article>


            <article class="form-card">
                <h3>🎬 Audiovisuais
                </h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" value="filmes">

                    <div class="form-group">
                        <label for="filme_id">ID *</label>
                        <input type="number" id="filme_id" name="id" required placeholder="Ex: 13">
                    </div>

                    <div class="form-group">
                        <label for="filme_titulo">Título *</label>
                        <input type="text" id="filme_titulo" name="titulo" required
                            placeholder="Ex: Quilombo dos Palmares">
                    </div>

                    <div class="form-group">
                        <label for="filme_desc">Descrição *</label>
                        <input type="text" id="filme_desc" name="desc" required placeholder="Breve descrição da obra">
                    </div>

                    <div class="form-group">
                        <label for="filme_link">Link *</label>
                        <input type="url" id="filme_link" name="link" required placeholder="https://...">
                    </div>

                    <div class="form-group">
                        <label for="filme_tipo">Tipo de Mídia *</label>
                        <select id="filme_tipo" name="tipomidia" required>
                            <option value="">Selecione...</option>
                            <option value="filmes">🎬 Longas de Ficção</option>
                            <option value="curtas">🎞️ Curtas</option>
                            <option value="desenhos">✏️ Animações</option>
                            <option value="documentarios">🎥 Documentários</option>
                            <option value="series">📺 Séries</option>
                            <option value="biografias">👤 Biografias</option>
                            <option value="clipes">🎵 Musicais</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-submit">Atualizar Mídia</button>
                    <p>Adicione uma mídia por vez.</p>
                </form>
            </article>

            <article class="form-card">
                <h3>⚖️ Legislação</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" value="legislacao">

                    <div class="form-group">
                        <label for="leg_id">ID *</label>
                        <input type="number" id="leg_id" name="id" required placeholder="Ex: 13">
                    </div>

                    <div class="form-group">
                        <label for="leg_titulo">Título *</label>
                        <input type="text" id="leg_titulo" name="titulo" required placeholder="Ex: Lei Afonso Arinos">
                    </div>

                    <div class="form-group">
                        <label for="leg_norma">Norma *</label>
                        <input type="text" id="leg_norma" name="norma" required placeholder="Ex: Lei nº 2.848/1940">
                    </div>

                    <div class="form-group">
                        <label for="leg_data">Data</label>
                        <input type="text" id="leg_data" name="data" required placeholder="Ex: 7 de dezembro de 1940">
                    </div>

                    <div class="form-group">
                        <label for="leg_link">Link</label>
                        <input type="text" id="leg_link" name="link" required placeholder="Ex: https://...">
                    </div>

                    <button type="submit" class="btn-submit">Enviar Legislação</button>
                    <p>Adicione uma legislação por vez.</p>
                </form>
            </article>

        </div>
    </main>


    <footer class="footer">
        <p>
            Trabalho de Conclusão de Curso apresentado ao curso técnico em Informática IFPR Pinhais
    </footer>


    <!-- VLibras Atualizadp -->
    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        const vw = new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>


    <script src="../Supabase/supabase.min.js"></script>
    <script>
        if (typeof window.SUPABASE_URL !== 'undefined') {
            const supabase = window.supabase.createClient(
                window.SUPABASE_URL,
                window.SUPABASE_KEY
            );

        }
    </script>

    <script>
        document.getElementById('secao').addEventListener('change', function () {

            switch (this.value) {

                case 'fotografias':
                    mostrarFotografias();
                    break;

                case 'pinturas':
                    mostrarPinturas();
                    break;

                case 'filmes':
                    mostrarFilmes();
                    break;

                case 'livros':
                    mostrarLivros();
                    break;

                case 'legislacao':
                    mostrarLegislacao();
                    break;

                default:
                    break;
            }

        });
    </script>

    <script>
        let dados = [];

        async function mostrarFotografias() {
            try {
                const response = await fetch('../api/Fotografias.php');
                dados = await response.json();
                let html = '';
                dados.forEach((item) => {
                    html += `
                    <p style="padding: 12px 15px; cursor: pointer; border-bottom: 1px solid rgb(243, 244, 246); transition: background 0.2s; background: white;" onmouseover="this.style.background='#fef3c7'" onmouseout="this.style.background='white'">
                    <img style="width: 200px; height: 100px; object-fit: cover; border-radius: 8px;" src="${item.url}"/>
                    <strong>${item.titulo}</strong><br>
                    ${item.autor} • ${item.ano}<br>
                    <strong>ID: ${item.id}</strong>
                    </p>
                    `;
                });
                document.getElementById('sugestoes').innerHTML = html;
            } catch (erro) {
                console.error(erro);
                document.getElementById('sugestoes').innerHTML =
                    'Erro ao consumir API';
            }
        }

        async function mostrarPinturas() {
            try {
                const response = await fetch('../api/Pinturas.php');
                dados = await response.json();
                let html = '';
                dados.forEach((item) => {
                    html += `
                    <p style="padding: 12px 15px; cursor: pointer; border-bottom: 1px solid rgb(243, 244, 246); transition: background 0.2s; background: white;" onmouseover="this.style.background='#fef3c7'" onmouseout="this.style.background='white'">
                    <img style="width: 200px; height: 100px; object-fit: cover; border-radius: 8px;" src="${item.url}"/>
                    <strong>${item.titulo}</strong><br>
                    ${item.autor} • ${item.ano}<br>
                    <strong>ID: ${item.id}</strong>
                    </p>
                    `;
                });
                document.getElementById('sugestoes').innerHTML = html;
            } catch (erro) {
                console.error(erro);
                document.getElementById('sugestoes').innerHTML =
                    'Erro ao consumir API';
            }
        }

        async function mostrarFilmes() {
            try {
                const response = await fetch('../api/Audiovisuais.php');
                dados = await response.json();
                let html = '';
                dados.forEach((item) => {
                    html += `
                    <p style="padding: 12px 15px; cursor: pointer; border-bottom: 1px solid rgb(243, 244, 246); transition: background 0.2s; background: white;" onmouseover="this.style.background='#fef3c7'" onmouseout="this.style.background='white'">
                    <img style="width: 200px; height: 100px; object-fit: cover; border-radius: 8px;" src="${item.url}"/>
                    <strong>${item.titulo}</strong><br>
                    <strong>ID: ${item.id}</strong>
                    </p>
                    `;
                });
                document.getElementById('sugestoes').innerHTML = html;
            } catch (erro) {
                console.error(erro);
                document.getElementById('sugestoes').innerHTML =
                    'Erro ao consumir API';
            }
        }

        async function mostrarLivros() {
            try {
                const response = await fetch('../api/Biblioteca.php');
                dados = await response.json();
                let html = '';
                dados.forEach((item) => {
                    html += `
                    <p style="padding: 12px 15px; cursor: pointer; border-bottom: 1px solid rgb(243, 244, 246); transition: background 0.2s; background: white;" onmouseover="this.style.background='#fef3c7'" onmouseout="this.style.background='white'">
                    <img style="width: 90px; height: 135px; object-fit: cover; border-radius: 8px;" src="${item.url}"/>
                    <strong>${item.titulo}</strong><br>
                    <strong>ID: ${item.id}</strong>
                    </p>
                    `;
                });
                document.getElementById('sugestoes').innerHTML = html;
            } catch (erro) {
                console.error(erro);
                document.getElementById('sugestoes').innerHTML =
                    'Erro ao consumir API';
            }
        }

        async function mostrarLegislacao() {
            try {
                const response = await fetch('../api/Legislacao.php');
                dados = await response.json();
                let html = '';
                dados.forEach((item) => {
                    html += `
                    <p style="padding: 12px 15px; cursor: pointer; border-bottom: 1px solid rgb(243, 244, 246); transition: background 0.2s; background: white;" onmouseover="this.style.background='#fef3c7'" onmouseout="this.style.background='white'">
                    <strong>Título: </strong>${item.titulo}<br>
                    <strong>Norma: </strong>${item.norma}<br>
                    <strong>Data: </strong>${item.data}<br>
                    <strong>Link: </strong>${item.link}<br>
                    <strong>ID: ${item.id}</strong>
                    </p>
                    `;
                });
                document.getElementById('sugestoes').innerHTML = html;
            } catch (erro) {
                console.error(erro);
                document.getElementById('sugestoes').innerHTML =
                    'Erro ao consumir API';
            }
        }
    </script>

    <script src="../mainStyle/script.js"></script>

</body>

</html>
