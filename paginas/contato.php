<?php include_once('../includes/header.php'); ?>

<main class="container-contato">
    
    <h1 class="titulo-pagina">Fale Conosco</h1>

    <p class="descricao-pagina">
        Tem dúvidas, sugestões ou quer entrar em contato conosco? Preencha o formulário abaixo e responderemos o mais breve possível.
    </p>

    <form action="#" method="POST" class="formulario-contato">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required placeholder="Seu nome completo">
        </div>

        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required placeholder="seuemail@exemplo.com">
        </div>

        <div class="form-group">
            <label for="mensagem">Mensagem:</label>
            <textarea id="mensagem" name="mensagem" rows="5" required placeholder="Escreva aqui sua mensagem..."></textarea>
        </div>

        <button type="submit" class="botao-enviar">Enviar Mensagem</button>
    </form>
</main>

<?php include_once('../includes/footer.php'); ?>