@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">

                        <form id="chatform" action="POST">
                            {{ csrf_field() }}
                            <p>Product Name : {{ $product->name }}</p>
                            <p>User Name : {{ $user->name }}</p>
                            <input name="product_id" type="hidden" value="{{ $product->id }}">
                            <div style="max-height: 300px;overflow-y: scroll">
                                <table id="chats" class="table table-responsive">
                                    @foreach($product->chat_messages()->where("user_id", $user->id)->get() as $cm)
                                        <tr>
                                            @if(!$cm->isFromUser)
                                                <td style="text-align: right">{{ $cm->body }}</td>
                                            @else
                                                <td style="text-align: left">{{ $cm->body }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <textarea name="body" class="form-control"></textarea>
                            <button id="send-btn" type="submit">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script type="text/javascript">

        Pusher.logToConsole = true;

        $("#chatform").on("submit", function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('opchat.send',["productid" => $product->id, "userid" => $user->id]) }}',
                method: $(this).attr('action'),
                dataType: 'json' ,
                data: $("textarea,input").serialize(),
                success: function(resp) {
                    $("#chatform")[0].reset();

                }
            });

        });

        Echo.private('product-chat_{{ $user->id }}_{{ $product->id }}').listen('ChatSent', function(data) {
            if(data.message.isFromUser) {
                $("#chats").append('<tr><td style="text-align: left">' + data.message.body + '</td></tr>')
            } else {
                $("#chats").append('<tr><td style="text-align: right">' + data.message.body + '</td></tr>')
            }
        });

        function fetchMessage(table) {
            $.getJSON('{{ route("opchat.fetch", ["productid" => $product->id, "userid" => $user->id]) }}', function(data) {

            });
        }

    </script>
@endsection