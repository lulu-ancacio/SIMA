<?php
session_start();
if (empty($_SESSION['adm'])) {
    header('Location: index.php');
    exit;
}

require_once '../config/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    match ($_POST['tipo']) {
        'sub' => supabaseCreateTerm($_SESSION['id']),
        'del' => supabaseDeleteItem('termos_uso'),
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
                        <li><a href="../Legislacao/Legislacao.html">Personalidades</a></li>
                        <li><a href=" ../LinhaDoTempo/LinhadoTempo.html">Linha do Tempo</a></li>
                        <li><a href="../personalidades/Personalidades.html">Personalidades</a></li>
                        <li><a href="../musica/Musica.html">Músicas</a></li>
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
        <h2 class="section-title">Controle de Termos de Uso</h2>

        <div class="forms-grid">


            <article class="form-card">
                <h3>Acessar Termos de Uso</h3>
                <form method="POST" enctype="multipart/form-data">

                    <div id="sugestoes"
                        style=" max-height:400px; overflow-y:auto; overflow-x:hidden; background:white; border:2px solid #e5e7eb; border-radius:8px; margin:20px">
                    </div>

                </form>
            </article>

            <article class="form-card">
                <h3>Submeter Termos de Uso</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" value="sub">

                    <div class="form-group">
                        <label for="termos_autor">Autor(a) *</label>
                        <input type="text" id="termos_autor" name="autor" required placeholder="Nome do autor">
                    </div>

                    <label for="termos_arquivo">Termo (PDF) *</label>
                    <input type="file" id="termos_arquivo" name="link" accept="application/pdf" required>

                    <button type="submit" class="btn-submit">Enviar Termo</button>
                    <p>Adicione um termo por vez.</p>
                </form>
            </article>

            <article class="form-card">
                <h3>Excluir Termos de Uso</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" value="del">

                    <label for="apagar_item"><strong>Qual ID do item que você deseja apagar?</strong></label>
                    <input type="number" id="apagar_item" name="id">
                    <button type="submit" class="btn-submit">Excluir Item</button>
                </form>
            </article>

        </div>
        <button
            onclick="window.open('https://docs.google.com/document/d/1u9u89bEDej1IgfXIat2Dl9XtmB2pfP5ahr8ODmKS5Iw/edit?usp=sharing')"
            class="btn-documentacao">
            Acessar modelo de Termo de Uso
        </button>
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
        let dados = [];
        async function mostrarTermos() {
            try {
                const response = await fetch('../api/Termos.php');
                dados = await response.json();
                let html = '';
                dados.forEach((item) => {
                    html += `
                    <a href="${item.link}" target="_blank">
                        <p style="padding: 12px 15px; cursor: pointer; border-bottom: 1px solid rgb(243, 244, 246); transition: background 0.2s; background: white;" onmouseover="this.style.background='#fef3c7'" onmouseout="this.style.background='white'">
                            Termo de uso de <strong>${item.autor}</strong><br>
                            <strong>ID: ${item.id}</strong>
                        </p>
                    </a>
                    `;
                });
                document.getElementById('sugestoes').innerHTML = html;
            } catch (erro) {
                console.error(erro);
                document.getElementById('sugestoes').innerHTML =
                    'Erro ao consumir API';
            }
        }
        mostrarTermos()
    </script>

    <script src="../mainStyle/script.js"></script>

</body>

</html>
