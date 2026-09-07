<?php
session_start();
if (empty($_SESSION['adm'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../mainStyle/assets/images/FavIcon_SF.png">
    <meta name="description" content="Painel Administrativo ">
    <title>GRIOT - Painel Administrativo</title>


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
                        <li><a href="../personalidades/Personalidades.html">Personalidades</a></li>
                        <li><a href="../musica/Musica.html"> Músicas</a></li>
                        <li><a href="../Legislacao/Legislacao.html">Legislação</a></li>
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
                    <a href="../Curso/curso.html" class="main-blue-button">Dúvidas na Curadoria?</a>
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
        <h2 class="section-title">Controle de Conteúdo</h2>

        <div class="forms-grid">
            <button onclick="window.location.href='../Submeter/submeter.php'" class="btn-submit">Submissão de
                obras</button>

            <button onclick="window.location.href='../Excluir/excluir.php'" class="btn-submit"><a>Exclusão de
                    obras</a></button>

            <button onclick="window.location.href='../Editar/editar.php'" class="btn-submit"><a>Edição de
                    obras</a></button>

            <button onclick="window.location.href='../Denuncia/Denuncia.php'" class="btn-submit"><a>Moderação de
                    Contéudo</a></button>

            <button onclick="window.location.href='../mensagemRecebida/mensagemRecebida.php'"
                class="btn-submit"><a>Controle de
                    Sugestões</a></button>

            <button onclick="window.location.href='../Termos/termos.php'" class="btn-submit"><a>Controle de
                    Termos de Uso</a></button>
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

    <script src="../mainStyle/script.js"></script>

</body>

</html>
