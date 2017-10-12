<span class="label label-default"
      data-toggle="popover"
      title="Comentarios"
      data-placement="bottom"
      data-content="<div>
@foreach($comentarios as $comment)
              <p class='text-muted well well-sm no-shadow'>
                {{$comment->comentario}}
                (<span class='label label-info'>{{$comment->user->email}}</span>)
                (<span class='label label-info'>{{(new DateTime($comment->created_at))->format('d/m/Y')}}</span>)
              </p>

      @endforeach
              </div>
              "
      data-html="true"
>
                            <i class="fa fa-comment-o"></i>
    </span>
