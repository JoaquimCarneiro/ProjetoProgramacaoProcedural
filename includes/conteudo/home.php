<section class="index-intro">
    <h1>Esta é a página inicial</h1>
    <p>... Introdução ...</p>
    <p><?php if(isset($message)){
        echo $message;
        } ?></p>
    <p>Sessão</p>
    <p><?php debug(true, $_SESSION); ?></p>
</section>

<section class="index-categories">
    <h2>Categorias exemplo</h2>
    <ul class="index-categories-lists">
        <li><h3>Banana</h3></li>
        <li><h3>Bimbo</h3></li>
        <li><h3>Miau</h3></li>
        <li><h3>fluff</h3></li>
    </ul>
</section>
