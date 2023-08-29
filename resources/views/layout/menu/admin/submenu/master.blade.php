<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-link text-white" href="{{ route('marital_status') }}">Marital Status</a>
            <a class="nav-link text-white" href="{{ route('ethnic') }}">Suku</a>
            <a class="nav-link text-white" href="{{ route('religion') }}">Agama</a>
            <a class="nav-link text-white" href="{{ route('code.index') }}">Code</a>
{{--            <a class="nav-link text-white" href="{{ route('code.vital-sign') }}">Vital Sign</a>--}}
            <a class="nav-link text-white" href="{{ route('kits.index') }}">ATM Kits</a>
            <a class="nav-link text-white" href="{{ route('baseLine.index') }}">Base Line</a>
            <a class="nav-link text-white" href="{{ route('education') }}">Pendidikan</a>
        </div>
    </div>
</nav>
