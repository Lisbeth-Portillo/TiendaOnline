function init() {
    //Conteo de productos del carrito
    itemsCard();
    //Mini carrito 

}

//Funcion comprobacion contraseña
function check_pass() {
    var val = document.getElementById("passr").value;
    var no = 0;
    if (val != "") {
        // Si la longitud de la contraseña es menor o igual a 6
        if (val.length <= 6) no = 1;

        // Si la longitud de la contraseña es superior a 6 y contiene cualquier alfabeto en minúsculas o cualquier número o carácter especial
        if (val.length > 6 && (val.match(/[a-z]/) || val.match(/\d+/) || val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))) no = 2;

        // Si la longitud de la contraseña es mayor que 6 y contiene alfabeto, número, carácter especial respectivamente
        if (val.length > 6 && ((val.match(/[a-z]/) && val.match(/\d+/)) || (val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (val.match(/[a-z]/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)))) no = 3;

        // Si la longitud de la contraseña es superior a 6 y debe contener letras, números y caracteres especiales
        if (val.length > 6 && val.match(/[a-z]/) && val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) no = 4;

        if (no == 1 || no == 2) {
            $("#meter").animate({ width: '33.33%' }, 300);
            meter.style.backgroundColor = "red";
        }

        if (no == 3) {
            $("#meter").animate({ width: '66.99%' }, 300);
            meter.style.backgroundColor = "orange";
        }

        if (no == 4) {
            $("#meter").animate({ width: '100%' }, 300);
            meter.style.backgroundColor = "darkgreen";
        }
    } else {
        meter.style.backgroundColor = "";
    }
}


//Agregar producto al carrito
function card() {
    amount = $("#product_qty").val();
    pro_id = $("#pro_id").val();
    costumer = $("#costumer").val();
    size = $('input:radio[name=size]:checked').val();
    if (amount == 0) {
        alertify.set('notifier', 'position', 'top-right');
        alertify.error('Eliga una cantidad mayor o igual a 1');
    } else {
        if (size == undefined) {
            alertify.set('notifier', 'position', 'top-right');
            alertify.error('Eliga una talla');
        } else {
            $.ajax({
                url: 'ajax/carrito.php?op=addcart',
                type: 'POST',
                async: true,
                datatype: 'json',
                data: $('#carrito').serialize(),

                success: function(response) {
                    //El producto ya esta en el carrito
                    if (response == "ya agregado") {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.error('El producto ya está agregado al carrito');

                    } else if (response == "agregado") {
                        //Producto agregado al carrito
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success('Producto agregado');
                        //Actualizar numero de productos en el carrito
                        itemsCard();

                    } else {
                        //Ha excedido la cantidad maxima del producto
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.error('No agregado, cantidad máxima ' + response);

                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    }
}

//Obtencion del número de productos en el carrito
function itemsCard() {
    $.ajax({
        url: 'ajax/carrito.php?op=itemscart',
        type: 'POST',
        async: true,

        success: function(response) {
            $("#CartItems").html(response);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

//Datos de contacto - Contactanos
function contact() {
    Name = $("#name").val();
    Email = $("#email").val();
    Phone = $("#phone").val();
    Subject = $("#subject").val();
    Message = $("#message").val();

    if (Name == "" || Email == "" || Phone == "" || Subject == "" || Message == "") {
        alertify.set('notifier', 'position', 'top-right');
        alertify.error('Todos los datos son necesarios');
    } else {
        $.ajax({
            url: 'sendemail.php',
            type: 'POST',
            async: true,
            datatype: 'json',
            data: $('#contact_form').serialize(),

            success: function(response) {
                if (response == '') {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success('Mensaje enviado exitosajkkjmente');
                } else {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success('Mensaje enviado exitosamente');
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
}


//Agregar productos a la lista de deseos
function wishlist($id) {

    $.ajax({
        url: 'ajax/wishlist.php?op=addlist',
        type: 'POST',
        async: true,
        datatype: 'json',
        data: { id: $id },

        success: function(response) {
            //Usuario no registrado
            if (response == 1) {
                alertify.set('notifier', 'position', 'top-right');
                alertify.error('Iniciar sesión para agregar un producto a la lista de deseos');
                $(location).attr("href", "login.php");
            }
            //Producto ya agregado
            if (response == 2) {
                alertify.set('notifier', 'position', 'top-right');
                alertify.error('Producto ya agregado');
            }

            //Producto agregado
            if (response == 3) {
                alertify.set('notifier', 'position', 'top-right');
                alertify.success('El producto se ha agregado');
                $("#wishlist").html("<i id='icon' class='icon anm anm-heart whish' aria-hidden='true'; ></i> Agregado<span></span>");
            }
        },
        error: function(error) {
            console.log(error);
        }
    });

}

//Remover producto de la lista de deseos
function RemoveWish($wish_id) {
    $.ajax({
        url: "ajax/wishlist.php?op=deletewish",
        method: "POST",
        data: {
            wish_id: $wish_id
        },

        success: function(data) {
            //Producto eliminado de lista de deseos
            if (data == 1) {
                alertify.set('notifier', 'position', 'top-right');
                alertify.success('Producto eliminado');
                //Actualizar datos de la pagina
                $("#wishlist-products").load("account/get.php?op=wishlist");

            } else {
                alertify.set('notifier', 'position', 'top-right');
                alertify.error('ERROR');
            }
        }

    });

}

$("#editaccount").validate({
    submitHandler: function(form) {

        $.ajax({
            url: 'ajax/user.php?op=edit',
            type: 'POST',
            async: true,
            datatype: 'json',
            data: $('#editaccount').serialize(),
            success: function(response) {
                //Datos actualizados
                if (response == 1) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success('Datos actualizados');
                    //Actualizar datos de la pagina
                    $("#accountedit").load("account/get2.php?op=updateAccount");
                }
                //Fallido, email duplicado
                if (response == 2) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error('Correo electrónico ya registrado');
                }

            },
            error: function(error) {
                console.log(error);

            }
        });
    }
});


function getval(sel) {
    $.get("municipio.php", "depart=" + $("#depart").val(), function(data) {
        $("#munic").html(data);
    });
}
init();