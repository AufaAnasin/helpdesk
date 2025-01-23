<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo" style="display: flex; align-items:center; justify-content: center;">
            {{-- <a href="#" class="simple-text logo-mini">{{ __('BD') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Black Dashboard') }}</a> --}}
            <img src="{{ asset('images/bailogo.png') }}" style="width: 100px; height: auto;" alt="BAI LOGO">
        </div>
        <ul class="nav">
            <li @if ($pageSlug == 'userlist') class="active " @endif>
                <a href="{{ route('user.list') }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ __('List of Users') }}</p>
                </a>
            </li>
            {{-- Troubleshooting --}}
            <li>
                <a data-toggle="collapse" href="#laravel-examples" aria-expanded="true">
                    <i class="fas fa-microchip"></i>
                    <span class="nav-link-text">{{ __('Troubleshooting') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse show" id="laravel-examples">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'tickets') class="active " @endif>
                            <a href="{{ route('tickets.list') }}">
                  
                                <p>{{ __('Tickets Ongoing') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'inputticket') class="active " @endif>
                            <a href="{{ route('inputticket') }}">
                                <p>{{ __('Input Ticket') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'user-tickets') class="active " @endif>
                            <a href="{{ route('user.tickets') }}">
                                <p>{{ __('My Tickets') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Goods Borrowing --}}
            {{-- <li>
                <a data-toggle="collapse" href="#goods-borrowing-toggle" aria-expanded="true">
                    <i class="far fa-handshake"></i>
                    <span class="nav-link-text">{{ __('Goods Borrowing') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse show" id="goods-borrowing-toggle">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'tickets') class="active " @endif>
                            <a href="{{ route('tickets.list') }}">
                                <p>{{ __('Tickets Ongoing') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'inputticket') class="active " @endif>
                            <a href="{{ route('inputticket') }}">
                                <p>{{ __('Input Ticket') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'user-tickets') class="active " @endif>
                            <a href="{{ route('user.tickets') }}">
                                <p>{{ __('My Tickets') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> --}}
            {{-- Assets Management --}}
            <li>
                <a data-toggle="collapse" href="#assets-management-toggle" aria-expanded="true">
                    <i class="fab fa-laravel"></i>
                    <span class="nav-link-text">{{ __('Assets Management') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse show" id="assets-management-toggle">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'register-assets') class="active " @endif>
                            <a href="{{ route('assetsmanagement.assetsregister') }}">
                                <p>{{ __('Register Assets') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'inputticket') class="active " @endif>
                            <a href="{{ route('inputticket') }}">
                                <p>{{ __('Request Assets') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'user-tickets') class="active " @endif>
                            <a href="{{ route('user.tickets') }}">
                                <p>{{ __('Requested Assets List') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'assets-list') class="active " @endif>
                            <a href="{{ route('assetsmanagement.assetslist') }}">
                                <p>{{ __('Assets List') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Regular Monitoring --}}
            {{-- <li>
                <a data-toggle="collapse" href="#laravel-examples" aria-expanded="true">
                    <i class="tim-icons icon-chart-bar-32"></i>
                    <span class="nav-link-text">{{ __('Regular Monitoring') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse show" id="laravel-examples">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'tickets') class="active " @endif>
                            <a href="{{ route('tickets.list') }}">
                                <p>{{ __('Tickets Ongoing') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'inputticket') class="active " @endif>
                            <a href="{{ route('inputticket') }}">
                                <p>{{ __('Input Ticket') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'user-tickets') class="active " @endif>
                            <a href="{{ route('user.tickets') }}">
                                <p>{{ __('My Tickets') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> --}}
            {{-- Application Request --}}
            {{-- <li>
                <a data-toggle="collapse" href="#laravel-examples" aria-expanded="true">
                    <i class="tim-icons icon-app"></i>
                    <span class="nav-link-text">{{ __('Application Request') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse show" id="laravel-examples">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'tickets') class="active " @endif>
                            <a href="{{ route('tickets.list') }}">
                                <i class="tim-icons icon-laptop"></i>
                                <p>{{ __('Tickets Ongoing') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'inputticket') class="active " @endif>
                            <a href="{{ route('inputticket') }}">
                                <i class=""></i>
                                <p>{{ __('Input Ticket') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'user-tickets') class="active " @endif>
                            <a href="{{ route('user.tickets') }}">
                                <i class=""></i>
                                <p>{{ __('My Tickets') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> --}}
        </ul>
    </div>
</div>
