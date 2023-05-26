<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/style.css') }}">
    <title>Elements du site</title>

</head>

<body>
    <header>
        <nav class="nav">
        </nav>
    </header>
    <div id="flex_part">
        <main>
            <hgroup>
                <h1 class="text_center">SERVICE INFORMATIQUE</h1>
                <h2 class="text_center">GESTION DES INCIDENTS</h2>
            </hgroup>
            <article>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <fieldset>
                        <legend>Connectez-vous</legend>
                        <label for="email" class="hidden"></label>
                        <input class="input bt_value" type="email" id="email" name="email" value=""
                            placeholder="Entrer votre email" required>
                        <label for="password" class="hidden">Entrer votre mot-de-passe</label>
                        <input class="input  bt_value" type="password" id="password" name="password"
                            placeholder="Entrer votre mot-de-passe" required>
                        <button class="input bt_ok pointer" name="button">Se connecter</button>
                        <div>
                            <input class="pointer" type="checkbox" id="scales" name="scales" checked>
                            <label for="scales">Se souvenir de moi ?</label>
                        </div>
                        <a class="input bt_nok pointer" name="">Mot-de-passe oublier ?</a>
                        <a class="input bt_nok pointer" href="{{ route('register') }}" name="">S'enregistrer</a>
                    </fieldset>
                </form>
            </article>
        </main>
        <footer>
            @include('templates.footer')
        </footer>
    </div>
</body>

</html>
