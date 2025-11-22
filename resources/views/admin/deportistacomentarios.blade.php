@foreach($valoraciones as $valoracion)
<div class="direct-chat-msg">
    <div class="direct-chat-infos clearfix">
        <span class="direct-chat-name float-left">
            {{ $valoracion->deportista->user->nombres }} {{ $valoracion->deportista->user->apellidos }}
        </span>
        <span class="direct-chat-timestamp float-right" style="color: #ffc107;">
            {{ $valoracion->created_at->format('d M Y H:i') }}
        </span>
    </div>
    <img class="direct-chat-img" src="{{ $valoracion->deportista->user->foto ? asset('storage/fotos/' . $valoracion->deportista->user->foto) : 'https://picsum.photos/300/300?random=' . $valoracion->id }}" alt="User Image">
    <div class="direct-chat-text">
        {{ $valoracion->comentario }}
    </div>
</div>
@endforeach

<div class="mt-2">
    {{ $valoraciones->links() }}
</div>
