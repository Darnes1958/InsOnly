<div>
    <div class="py-2">
        {{ $this->form }}
    </div>

    {{ $this->table }}
</div>

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
        @this.on('goto', (event) => {
            postid = (event.test);
            if (postid == 'search') {
                $("#search").focus();
                $("#search").select();
            }
            if (postid == 'ksmdate') {
                $("#ksmdate").focus();
                $("#ksmdate").select();
            }
            if (postid == 'ksmnotes') {
                $("#ksmnotes").focus();
                $("#ksmnotes").select();
            }
        });
        });
    </script>
@endpush

