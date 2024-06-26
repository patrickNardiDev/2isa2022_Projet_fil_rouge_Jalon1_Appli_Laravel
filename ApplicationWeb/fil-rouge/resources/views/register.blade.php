<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('templates.favicon')
    @vite('resources/js/register.js')
    <title>S'enregistrer - Gestion des incidents - AMIO</title>

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
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <fieldset>
                        <legend>Enregistrez-vous</legend>
                        @if (session('status'))
                            <div class="success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <label for="name" hidden>Nom</label>
                        <input class="input bt_value @error('name') is-invalid @enderror" type="text" name="name"
                            value="{{ old('name') }}" autofocus placeholder="Entrez votre nom..." required />
                        @error('name')
                            <div class="error">Il existe un problème vis-à-vis votre nom</div>
                        @enderror
                        <label for="firstname @error('firstname') is-invalid @enderror" hidden>Prénom</label>
                        <input class="input bt_value " type="text" name="firstname" value="{{ old('firstname') }}"
                            placeholder="Entrez votre prénom..." required />
                        @error('firstname')
                            <div class="error">Il existe un problème vis-à-vis votre prénom</div>
                        @enderror
                        <label for="tel" hidden>Téléphone</label>
                        <input class="input bt_value @error('tel') is-invalid @enderror" type="text" name="tel"
                            placeholder="Entrez votre numéro de téléphone..." />
                        @error('tel')
                            <div class="error">Il existe un problème vis-à-vis votre numéro de téléphone</div>
                        @enderror
                        <label for="email" hidden>Email</label>
                        <input class="input bt_value @error('email') is-invalid @enderror" type="email" name="email"
                            value="{{ old('email') }}" placeholder="Entrez votre email..." required />
                        @error('email')
                            <div class="error">Il existe un problème vis-à-vis votre mail</div>
                        @enderror
                        <label for="password" hidden>Mot de passe</label>
                        <input class="input bt_value @error('password') is-invalid @enderror" type="password"
                            name="password" placeholder="Entrez votre mot de passe..." required />
                        <div onclick="showDiv()" id="rules_password" class="container text-clignote pointer">
                            {{-- <div onclick="showDiv()" id="rules_password" class="container text-clignote"> --}}
                            <img id="dartrules" class="icon_advance no_margin_top display_inlineblock"
                                src="/img/fleche.svg" alt="cliquez ici">
                            Règles des mots de passe
                            <div id="The_rules_password" class="bt_value ">
                                <div class="display_none" data-rulespassword="rule_password">au moins une lettre
                                    majuscule</div>
                                <div class="display_none" data-rulespassword="rule_password">au moins un chiffre</div>
                                <div class="display_none" data-rulespassword="rule_password">au moins un caractère
                                    spécial</div>
                                <div class="display_none" data-rulespassword="rule_password">longueur minimale de 8
                                    caractères</div>
                            </div>
                        </div>
                        @error('password')
                            <div class="error">Il existe un problème vis-à-vis votre mot de passe</div>
                        @enderror
                        <label for="password_confirmation" hidden>Confirmer le mot de passe</label>
                        <input class="no_margin_top input bt_value @error('password_confirmation') is-invalid @enderror"
                            type="password" name="password_confirmation" placeholder="Confirmer votre mot-de-passe..."
                            required />
                        @error('password_confirmation')
                            <div class="error">Il existe un problème vis-à-vis la confirmation de votre confirmation de mot
                                de passe</div>
                        @enderror
                        <button class="input bt_ok pointer" name="button" type="submit">S'enregistrer</button>
                        <a class="input bt_nok pointer" href="{{ route('login') }}">Déjà enregistré ?</a>
                    </fieldset>
                </form>
            </article>
        </main>
        <footer>
            @include('templates.footer')
        </footer>
    </div>
</body>
<script defer>
    // affichage des règles du mot de passe
    function showDiv() {

        const dartrules = document.getElementById("dartrules");
        const divRules = document.getElementById("rules_password");
        const divsRules = document.querySelectorAll('[data-rulespassword]');

        if (divsRules[0].className == "display_none") {
            for (let index = 0; index < divsRules.length; index++) {
                divsRules[index].classList.remove("display_none");
                divsRules[index].classList.add("display_block");
                divsRules[index].classList.add("colorrules");

            }
            divRules.classList.add("showcontenaire");
            dartrules.classList.add("display_none");
        } else {
            for (let index = 0; index < divsRules.length; index++) {

                divsRules[index].classList.remove("display_block");
                divsRules[index].classList.add("display_none");
                divsRules[index].classList.remove("colorrules");

            }
            divRules.classList.remove("showcontenaire");
            dartrules.classList.remove("display_none");
        }
    }
</script>

</html>
