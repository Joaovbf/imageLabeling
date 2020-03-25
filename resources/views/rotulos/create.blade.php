@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h4>Inserir Imagem Com Rótulo</h4>
        </div>
        <div class="row justify-content-center">
            <div class="col-8">
                <div id="pegarImagem" class="card w-100">
                    <div class="card-body">
                        <h5 class="card-title">Seleção de imagem</h5>
                        <div class="form-group">
                            <input class="form-control" type="file" form="enviarImagem" name="imagem" id="arquivo" accept="image/*">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="button" id="selecionar">Selecionar imagem</button>
                    </div>
                </div>
                <div id="rotulo" class="card w-100" style="display: none">
                    <img id="imagem" src="" class="card-img-top" alt="Imagem enviada pelo usuário">
                    <div class="card-body">
                        <div class="alert-info alert">
                            <h5 class="card-title">Clique na foto para selecionar uma área</h5>
                        </div>
                        <form id="enviarImagem" action="{{ route('rotulo.store') }}" method="post" >
                            @csrf
                            <div class="form-group">
                                <label for="rotulo">Nome do Rótulo</label>
                                <input type="text" name="rotulo" id="rotulo" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="posicaoX">X:</label>
                                <input id="posicaoX" type="text" class="form-control" name="posicaoX">
                                <label for="posicaoY">Y:</label>
                                <input id="posicaoY" type="text" class="form-control" name="posicaoY">
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit" form="enviarImagem">Cadastrar Rótulo</button>
                        <button class="btn btn-default" type="reset" form="enviarImagem" id="voltar">Selecionar Outra Foto</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function obterPosicao(mouseEvent,obj) {
            var obj_left = 0;
            var obj_top = 0;
            var xpos;
            var ypos;
            while (obj.offsetParent){
                obj_left += obj.offsetLeft;
                obj_top += obj.offsetTop;
                obj = obj.offsetParent;
            }
            if (mouseEvent){
                //FireFox
                xpos = mouseEvent.pageX;
                ypos = mouseEvent.pageY;
            }
            else {
                //IE
                xpos = window.event.x + document.body.scrollLeft - 2;
                ypos = window.event.y + document.body.scrollTop - 2;
            }
            xpos -= obj_left;
            ypos -= obj_top;

            return {xpos,ypos}
        }

        function obterPosicaoOriginal(event, element) {
            let {xpos,ypos} = obterPosicao(event, element)

            xpos = Math.round(xpos * element.naturalWidth/element.width)
            ypos = Math.round(ypos * element.naturalHeight/element.height)

            return {xpos,ypos}
        }

        function mostrarImagem(input){
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#imagem').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        window.onload = () => {
            $("#imagem").click(function (event){
                console.log(this)
                let {xpos, ypos} = obterPosicaoOriginal(event,this)
                document.querySelector("#posicaoX").value = xpos
                document.querySelector("#posicaoY").value = ypos
            });

            document.querySelector("#voltar").onclick = (event) => {
                $("#rotulo").hide()
                $("#pegarImagem").fadeIn()
            }

            document.querySelector("#selecionar").onclick = (event) => {
                try{
                    mostrarImagem(document.querySelector("#arquivo"))
                }catch (e) {
                    alert(e.toString())
                }
                $("#pegarImagem").hide()
                $("#rotulo").fadeIn()
            }
        }
    </script>
@endsection
