<?php
session_start();
if (empty($_SESSION['adm'])) {
    header('Location: index.php');
    exit;
}

require_once '../config/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    match ($_POST['tipo']) {
        'fotografias' => supabaseCreatePhotoPainting('Fotografias', 'fotografias', $_SESSION['id']),
        'pinturas' => supabaseCreatePhotoPainting('Pinturas', 'pinturas', $_SESSION['id']),
        'filmes' => supabaseCreateFilm($_SESSION['id']),
        'livros' => supabaseCreateBook($_SESSION['id']),
        'legislacao' => supabaseCreateLegislation($_SESSION['id']),
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
    <title>GRIOT - Painel de Submissão</title>
    <link rel="stylesheet" href="../mainStyle/assets/fonts/poppins.css">
    <link rel="stylesheet" href="../mainStyle/assets/css/templatemo-space-dynamic.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />




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
        <h2 class="section-title">Submissão de Conteúdo</h2>

        <div class="forms-grid">


            <article class="form-card">
                <h3>📷 Fotografias</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" value="fotografias">

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

                    <div class="form-group">
                        <label for="foto_imagem">Imagem *</label>
                        <input type="file" id="foto_imagem" name="imagem" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn-submit">Enviar Fotografia</button>
                    <p>Adicione uma fotografia por vez.</p>
                </form>
            </article>

            <article class="form-card">
                <h3>🎨 Pinturas</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" value="pinturas">

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

                    <div class="form-group">
                        <label for="pint_imagem">Imagem *</label>
                        <input type="file" id="pint_imagem" name="imagem" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn-submit">Enviar Pintura</button>
                    <p>Adicione uma pintura por vez.</p>
                </form>
            </article>


            <article class="form-card">
                <h3>📚 Acervo literário</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" value="livros">

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

                    <div class="form-group">
                        <p>Esta obra literário é de <strong>domínio público</strong>?</p>
                        <input type="radio" id="livros_cc0_true" name="cc0" value="True" onClick="painelCc0(this)"
                            onkeydown="if(event.keyCode === 13 || event.keyCode === 32) painelCc0(this)">
                        <label for="livros_cc0_true">Sim</label><br>
                        <input type="radio" id="livros_cc0_false" name="cc0" value="False" onClick="painelCc0(this)"
                            onkeydown="if(event.keyCode === 13 || event.keyCode === 32) painelCc0(this)">
                        <label for="livros_cc0_false">Não</label><br>
                    </div>

                    <div class="form-group" id="painelToCc0">
                    </div>

                    <div class="form-group">
                        <p>Esta obra literário possui capa?</p>
                        <input type="radio" id="livros_capa_true" name="capa" value="True"
                            onClick="showImagemInput(this)"
                            onkeydown="if(event.keyCode === 13 || event.keyCode === 32) showImagemInput(this)">


                        >
                        <label for="livros_capa_true">Sim</label><br>
                        <input type="radio" id="livros_capa_false" name="capa" value="False"
                            onClick="showImagemInput(this)"
                            onkeydown="if(event.keyCode === 13 || event.keyCode === 32) showImagemInput(this)">
                        <label for="livros_capa_false">Não</label><br>
                    </div>

                    <div class="form-group" id="imagemCapa">
                    </div>

                    <button type="submit" class="btn-submit">Enviar Obra</button>
                    <p>Adicione uma obra por vez.</p>
                </form>
            </article>


            <article class="form-card">
                <h3>🎬Audiovisuais</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" value="filmes">

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

                    <div class="form-group">
                        <label for="filme_capa">Imagem de Capa *</label>
                        <input type="file" id="filme_capa" name="imagem" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn-submit">Enviar Mídia</button>
                    <p>Adicione uma mídia por vez.</p>
                </form>
            </article>

            <article class="form-card">
                <h3>⚖️ Legislação</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" value="legislacao">

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
                    <p>Adicione uma lesgilação por vez.</p>
                </form>
            </article>

        </div>
    </main>


    <footer class="footer">
        <p>
            Trabalho de Conclusão de Curso apresentado ao curso técnico em Informática IFPR Pinhais
    </footer>


    <script src="../mainStyle/script.js" defer></script>

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


    <script src="Supabase/supabase.min.js"></script>
    <script>
        if (typeof window.SUPABASE_URL !== 'undefined') {
            const supabase = window.supabase.createClient(
                window.SUPABASE_URL,
                window.SUPABASE_KEY
            );

        }
    </script>

    <script>
        function painelCc0(elemento) {
            let valor = elemento.value;
            let html = '';

            if (valor == "True") {
                html += `
                    <label for="livros_arquivo">Livro (PDF) *</label>
                    <input type="file" id="livros_arquivo" name="link" accept="application/pdf" required>
                `;
            } else {
                html += `
                    <label for="livros_arquivo">Link de compra *</label>
                    <input type="text" id="livros_arquivo" name="link" placeholder="https://...">
                `;
            }
            document.getElementById('painelToCc0').innerHTML = html;
        }

        function showImagemInput(elemento) {
            let valor = elemento.value;
            let html = '';

            if (valor == "True") {
                html += `
                    <label for="livros_imagem">Capa do livro *</label>
                    <input type="file" id="livros_imagem" name="imagem" accept="image/*" required>
                `;
            } else {
                html += `
                    <input type="file" id="livros_imagem" name="imagem" style="display: none;">
                `;
            }
            document.getElementById('imagemCapa').innerHTML = html;
        }
    </script>

    <script src="../mainStyle/script.js"></script>

</body>

</html>
