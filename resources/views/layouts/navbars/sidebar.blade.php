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
            <li @if ($pageSlug == 'tickets') class="active " @endif>
                <a href="{{ route('tickets.list') }}">
                    <i class="tim-icons icon-laptop"></i>
                    <p>{{ __('Tickets Ongoing') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'inputticket') class="active " @endif>
                <a href="{{ route('inputticket') }}">
                    <i class="tim-icons icon-minimal-right"></i>
                    <p>{{ __('Input Ticket') }}</p>
                </a>
            </li>
    </div>
</div>
