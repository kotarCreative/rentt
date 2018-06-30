<div id="footer">
    <ul class="footer-nav right">
        @if(!Request::is('/'))
        <li class="footer-nav-item">
            <a href="/">Home</a>
        </li>
        @endif
        @if(!Request::is('about'))
        <li class="footer-nav-item">
            <a href="/about">About</a>
        </li>
        @endif
        @if(!Request::is('feedback'))
        <li class="footer-nav-item">
            <a href="/feedback">Feedback</a>
        </li>
        @endif
        @if(!Request::is('privacy'))
        <li class="footer-nav-item">
            <a href="/privacy">Privacy</a>
        </li>
        @endif
    </ul>
</div>
