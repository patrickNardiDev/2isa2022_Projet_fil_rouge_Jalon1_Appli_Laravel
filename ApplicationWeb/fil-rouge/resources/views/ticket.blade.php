@extends('template')

@section('title')
    Service informatique AMIO - Incident
@endsection

@section('contenu')
    @if (!empty($data))
        <article>
            <section>
                <details class="detail_ticket" open>
                    <summary class="border">
                        <h3>{{ $data[0]->nom }}</h3>
                        <p class="txt_inline">n° <span class="ticket_values">{{ $data[0]->id_ticket }}</span>
                        </p>
                    </summary>
                    <div class="border" id="incident_detail">
                        @include('templates.request_result')
                        <p class="statut_zone">
                            <span>
                                Statut :
                                <span class="ticket_values">
                                    @switch($data[0]->id_status)
                                        @case(11111)
                                            Ouvert <img class="icon_advance" src="/img/red.svg" alt="">
                                        @break

                                        @case(22222)
                                            En-cours <img class="icon_advance" src="/img/yellow.svg" alt="">
                                        @break

                                        @case(33333)
                                            Clôturé <img class="icon_advance" src="/img/green.svg" alt="">
                                        @break
                                    @endswitch
                                </span>
                            </span>
                            @if ($data[0]->id_status != 33333 && session()->get('IsTecHotline') == true)
                                <span>
                                    <form class="" action="{{ route('closeticket', ['nb' => $data[0]->id_ticket]) }}"
                                        method="POST">
                                        @csrf
                                        <button class="bt_submit bt_close_ticket" type="submit">Clôturer</button>
                                    </form>
                                </span>
                            @endif
                        </p>
                        @include('templates.request_result')
                        <p class="txt_inline">
                            <label for="panne_type"></label>
                            Type de panne :
                            <span class="ticket_values">
                                {{ $data[0]->label_panne }}
                            </span>
                        </p>
                        <p class="txt_inline">Date d’ouverture : <time class="ticket_values"
                                datetime="{{ $data[0]->date_de_creation }}">{{ $data[0]->date_de_creation }}</time>
                        </p>
                        <p class="txt_inline">Dernière mise à jour : <time class="ticket_values"
                                datetime="{{ $data[0]->date_de_maj }}">{{ $data[0]->date_de_maj }}</time>
                        </p>
                        <p class="txt_inline sujet">Sujet : <span class="ticket_values">{{ $data[0]->sujet }}</span>
                        </p>
                    </div>
                </details>
            </section>
            <section>
                <div>
                    <div>
                        <h3 class="hidden">Messages</h3>
                    </div>
                    <div class="chat-container">
                        <ul class="chat">
                            @foreach ($data as $message)
                                @php
                                    $maclasse = '';
                                    if (auth()->user()->id == $message->id_user) {
                                        $maclasse = 'message right';
                                    } else {
                                        $maclasse = 'message left';
                                    }
                                    if ($message->id_role == 77002 && !$isTicketOfThisTecHotline) {
                                        $maclasse .= ' techhotline';
                                    } else {
                                        $maclasse .= ' usager';
                                    }
                                @endphp

                                <li @if (!$isTicketOfThisTecHotline && !$isTicketOfTecHotline && $message->id_role == 77002) class="{{ $maclasse }}"><img class="logo" src="/img/help-desk-technical-support.svg" alt="technicien"> 
                                    @else
                                    class="{{ $maclasse }}"><img class="logo" src="/img/computer-icons-clip-art-man.svg" alt="usager"> @endif
                                    <p>
                                    {{ $message->msg }}
                                    </p>
                                    <div class="date">
                                        <p>
                                            @if ($message->id_user != auth()->user()->id)
                                                <span>{{ $message->nom }} </span>
                                            @endif
                                            <time datetime="{{ $message->date_message }}">{{ $message->date_message }}
                                            </time>
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @if ($data[0]->id_status != 33333)
                            <form class="chat-form" action="{{ route('postmessage', ['nb' => $data[0]->id_ticket]) }}"
                                method="POST">
                                @csrf
                                <textarea class="text_input @error('message') is-invalid @enderror" name="message" id="" cols="30"
                                    rows="4" type="text" placeholder="Message..."></textarea>
                                @error('message')
                                    <div class="error">Veuillez entrer un texte de deux carractères minimun</div>
                                @enderror
                                <button class="input bt_submit" type="submit">Envoyer</button>
                                @include('templates.request_result')
                            </form>
                        @endif
                    </div>
                </div>

            </section>
        </article>
        <script defer>
            const details = document.getElementsByClassName("detail_ticket")[0];
            details.addEventListener("toggle", (event) => {
                if (details.open) {
                    details.classList.remove("borderBlue");
                } else {
                    details.classList.add("borderBlue");
                }
            });
        </script>
    @endif

@endsection
