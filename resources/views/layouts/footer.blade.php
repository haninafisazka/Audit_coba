<footer class="text-light pt-3 pb-3 @if(Auth::user()->hasRole('auditor')) bg-dark @elseif(Auth::user()->hasRole('auditee'))
    bg-primary @else bg-danger @endif container-fluid">
    <div class="text-center">
        Copyright © 2023 Universitas Sebelas Maret
    </div>
</footer>
