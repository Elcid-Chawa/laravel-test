<!DOCTYPE html>
<html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <title>Coalition Test | Laravel </title>
    </head>
    <body>
        <div class="container">
            <div><h1> Add Products </h1></div>
            <form class="form" id="productForm" >
                @csrf
                <div class=" row mb-3">
                    <label class="col-sm-2 col-form-label" for="product_name">Product Name:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="product_name" name="product_name" value=""  />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="quantity">Quantity</label>
                    <div class="col-sm-4">
                     <input type="number" class="form-control"  id="quantity" name="quantity" value=""  />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="unit_price">Unit Price</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="unit_price" name="unit_price" value=""  />
                    </div>
                </div>
                <button type="button" onclick='createProduct()' class="btn btn-success">Create Product</button>
            </form>

            <div class="pt-5">
            <h1>Product Lists</h1>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Product Name</th>
                            <th scope="col">Quantity in stock</th>
                            <th scope="col"> Price per item</th>
                            <th scope="col">Datetime submitted</th>
                            <th scope="col">Total value number</th>
                        </tr>
                    </thead>
                    <tbody id="products-list" name="products-list">
                    </tbody>
                </table>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            function createProduct(){
                const data = $('#productForm').serialize();
                $.ajax({
                    type: 'POST',
                    url: '{{ route("createProduct") }}',
                    data: data,
                    dataType: 'json',
                    success: function(res){
                        alert("Product added Success!!");
                    },
                    error: function(){
                        console.log("some error")
                    }
                    
                }).done(function(){
                    $.ajax({
                        type: 'GET',
                        url: '/storage/data.json',
                        dataType: 'json',
                        success: function(res){
                            const tableBody = document.getElementById('products-list');
                            tableBody.innerHTML = '';
                            // console.log(res[0]);
                            let total=0;
                            res.map((d ) => {
                                let datarow = document.createElement('tr');
                                let date = new Date(d.created_at);
                                datarow.innerHTML = "<td>" + d.product_name + "</td>\
                                                        <td>" + d.quantity + "</td>\
                                                        <td>" + d.unit_price + "</td>\
                                                        <td>" + date + "</td>\
                                                        <td>" + d.unit_price * d.quantity + "</td>";
                                tableBody.appendChild(datarow);
                                total = total + (d.unit_price * d.quantity);
                            })
                            let lastRow = document.createElement('tr');
                            lastRow.innerHTML = `<td colspan="4">Total: </td><td>${total}</td>`
                            tableBody.appendChild(lastRow);
                        },
                        error:function(){
                            alert('error');
                        }
                    });
                });
            }
        </script>
    </body>
</html>