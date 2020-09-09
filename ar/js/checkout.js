$(function(){
    function handleError(error,textStatus,errorThrown){
        let message = "Unkown Error Occurred Please check your connection and try again later.";
    
        if(typeof error.responseJSON.message == "string") message = error.responseJSON.message;
    
        Swal.fire({
            type: 'error',
            title:"Error Occurred",
            text:message,
            allowOutsideClick:false,
        }).then(res => {
            if(error.status == 401){
                window.open("/login","_self");
            }
        });
    }
    $("#weaccept-form").submit(e => {
        e.preventDefault();
        if(!document.getElementById("wallet_info_form").reportValidity()) return;
    
        let mobile_number = $("#mobile_number_wallet").val();
        $.ajax({
            url:"/weaccept/wallet",
            type:"post",
            data:{
                mobile_number:mobile_number,
            },
            beforeSend:showLoading,
            success:(data,textStatus,response) =>{
                if(response.status == 201){
                    location.replace(data.redirect_url);
                }
            },
            error: handleError,
            complete: hideLoading,
        })
    })
    $("#weaccept-cash-form").submit((e) =>{
        e.preventDefault();
    
        const infoForm = document.getElementById("cash_info");
    
        if(!infoForm.reportValidity()) return;
    
        const formData = new FormData(infoForm);
    
        $.ajax({
            url:"/weaccept/cash",
            type:"post",
            data:formData,
            processData:false,
            contentType: false,
            beforeSend:showLoading,
            success:(data,status,jxhr) =>{
                if(jxhr.status == 201){
                    Swal.fire({
                        titleText:"Payment Pending",
                        html:`
                            <p>Your payment has been scheduled, our agent will contact you soon to collect the cash</p>
                            <p>Your order will be placed once the cash has collected</p>
                        `,
                        type:'success',
                        allowOutsideClick:false,
                    }).then(res => {
                        location.pathname = "/ar/payments";
                    });
                }
            },
            error: handleError,
    
            complete:hideLoading,
        });
    });
    
    $("#weaccept-kiosk").submit((e) => {
        e.preventDefault();
    
        const infoForm = document.getElementById("edit_local_form");
    
        if(!infoForm.reportValidity()) return;
    
        const formData = new FormData(infoForm);
    
        $.ajax({
            url:"/weaccept/kiosk",
            type:"post",
            processData:false,
            contentType: false,
            data:formData,
            beforeSend:showLoading,
            success:(data,status,jxhr) =>{
                if(jxhr.status == 201){
                    Swal.fire({
                        titleText:"Payment Pending",
                        html:`
                            <p>To pay, go to the nearest Aman or Masary or Momkn outlet, ask for "مدفوعات اكسبت/ Madfouaat Accept" and provide your reference number.</p>
                            <h4>Reference number: ${data.reference_number}.</h4>
                        `,
                        type:'success',
                        allowOutsideClick:false,
                    }).then(res => {
                        location.pathname = "/ar/payments";
                    });
                }
            },
            error: handleError,
            complete:hideLoading,
        });
    })
    function showLoading(){
        let wait = document.getElementById("wait");
    
        if(wait == null) {
            wait = document.createElement("div");
    
            wait.setAttribute("id","wait");
    
            document.body.appendChild(wait);
        }
    
        wait.style.backdropFilter = "blur(2px)";
        wait.classList.add("loader");
    }
    function hideLoading(){
        let wait = document.getElementById("wait");
    
        if(wait == null) return;
    
        wait.classList.remove("loader");
    }
    
    
})