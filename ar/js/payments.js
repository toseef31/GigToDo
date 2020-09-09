$(function(){
    let checkStatusLoading = false;
    $(".check-payment-status").on("click", function(e){
        if(checkStatusLoading) return;

        const transaction_id = $(this).data("weaccept-transaction"),
              $this = $(this);

            if(typeof transaction_id == "undefined") return;

        $.ajax({
            url:"/weaccept/transactions",
            data:{
                transaction_id:transaction_id,
                action:"check_status",
            },
            type:"POST",
            beforeSend: function(){
                $this.addClass("loading");
            },
            success:function(data){
                let statusEl = $this.siblings("span"),
                    orderStatus = $this.parent(".payment-status").siblings(".order-status"),
                    paymentId = orderStatus.data("payment-id");
                    statusEl.text(data.status);
                    statusEl.removeClass("success pending void");
                    statusEl.addClass(data.status);

                    if(data.status == "success"){
                        $this.removeClass("check-payment-status pending fa-refresh fa");
                        $this.addClass("fa-check fal text-success font-weight-bold");
                        $this.removeAttr("data-weaccept-transaction");
                        $this.removeAttr("title");
                        if(data.orderCreated){
                            orderStatus.html(`<span class="text-success">Created</span>`);
                        }else{
                            orderStatus.html(`<a href="/ar/weaccept/create_order?payment_id=${paymentId}" style=" color: #FF0000;">Create Order</a>`);
                        }
                    }
            },
            error:function(){
                Swal.fire({
                    title:"Error Occurred",
                    text:"Error occurred while checking your pyament status please check your connection and try again later.",
                    type:"error",
                });
            },
            complete:function(){
                $this.removeClass("loading");
            }
        })
    });
   $(document).ready(function(e){
        const queryParams = new URLSearchParams(location.search);
    
        if(queryParams.has("payment_failed") && queryParams.has("payment_type")){
            Swal.fire({
                type:"error",
                title:"Payment Faild",
                html:`Your <strong style="text-transform:capitalize">${queryParams.get("payment_type")} payment</strong> has failed during proccessing plaser check your balance and try again.`,
            });
        }
    });
});