<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <style>
        .hero.is-fullheight {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .box {
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .title {
            color: #363636;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .already-registered {
            display: block;
            text-align: right;
            margin-top: -10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column is-5-tablet is-4-desktop is-3-widescreen">
                        <div class="box">
                            <h1 class="title is-3">Créer un compte</h1>

                            <!-- Session Status -->
                            @if (session('status'))
                                <div class="notification is-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- Name -->
                                <div class="field">
                                    <label for="name" class="label">Nom</label>
                                    <div class="control has-icons-left">
                                        <input id="name" type="text" class="input @error('name') is-danger @enderror"
                                               name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    @error('name')
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="field">
                                    <label for="email" class="label">Email</label>
                                    <div class="control has-icons-left">
                                        <input id="email" type="email" class="input @error('email') is-danger @enderror"
                                               name="email" value="{{ old('email') }}" required autocomplete="email">
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                    </div>
                                    @error('email')
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="field">
                                    <label for="password" class="label">Mot de passe</label>
                                    <div class="control has-icons-left">
                                        <input id="password" type="password"
                                               class="input @error('password') is-danger @enderror"
                                               name="password" required autocomplete="new-password">
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="field">
                                    <label for="password_confirmation" class="label">Confirmer le mot de passe</label>
                                    <div class="control has-icons-left">
                                        <input id="password_confirmation" type="password"
                                               class="input" name="password_confirmation" required
                                               autocomplete="new-password">
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </div>
                                </div>

                                <!-- Already Registered -->
                                @if (Route::has('login'))
                                    <a class="already-registered" href="{{ route('login') }}">
                                        Déjà inscrit ?
                                    </a>
                                @endif

                                <!-- Submit Button -->
                                <div class="field">
                                    <button type="submit" class="button is-primary is-fullwidth">
                                        <span class="icon">
                                            <i class="fas fa-user-plus"></i>
                                        </span>
                                        <span>S'inscrire</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Font Awesome pour les icônes -->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
</body>
</html>
