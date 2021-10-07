<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.3.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    <title>Cek Ongkir</title>
    <style>

        .loader {
          display: inline-block;
          width: 80px;
          height: 80px;
          position: fixed;
          z-index: 9999999;
          top: 50%;
          left: 50%;
          margin-left: auto;
          margin-right: auto;
        }
        .loader:after {
          content: " ";
          display: block;
          width: 64px;
          height: 64px;
          margin: 8px;
          border-radius: 50%;
          border: 6px solid #fff;
          border-color: #6777EF transparent #6777EF transparent;
          animation: loader 1.2s linear infinite;
    
        }
        @keyframes loader {
          0% {
            transform: rotate(0deg);
          }
          100% {
            transform: rotate(360deg);
          }
        }
        
        .table-judul td {
            padding:8px;
        }

        .table-hasil td {
            border: none;
            padding: 5px 10px;
        }

        .table-hasil tr {
            padding: 0px;
        }

        .table-hasil h5 {
            margin: 0px;
        }

        .cost {
            color: #4f6b99;
        }
    
    </style>
</head>
<body style="background: #f3f3f3">
<div class="loader" style="display: none;"></div>
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">Cek Ongkir</h3>
                    <hr>
                    <form id="formTampilkan">
                        <div class="form-group">
                            <label class="font-weight-bold">PROVINSI ASAL</label>
                            <select class="form-control" name="province_origin" id="province_origin" required>
                                <option value="0">-- pilih provinsi --</option>
                                <option value="{{ $provinsiAsal->province_id }}">{{ $provinsiAsal->province }}</option>                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">KOTA / KABUPATEN ASAL</label>
                            <select class="form-control" name="city_origin" id="city_origin" required>
                                <option value="">-- pilih kota --</option>
                                <option value="{{ $kotaAsal->city_id }}">{{ $kotaAsal->city_name }}</option>
                            </select>
                        </div>
                        <div class="form-group">                          
                            <label class="font-weight-bold">PROVINSI TUJUAN</label>
                            <select class="form-control" onchange="getCity(this.value)" name="province_destination" id="province_destination" required>
                                <option value="0">-- pilih provinsi --</option>                                
                                @foreach ($provinces as $item)
                                    <option value="{{ $item->province_id }}">{{ $item->province }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">KOTA / KABUPATEN TUJUAN</label>
                            <select class="form-control" name="city_destination" id="city_destination" required>
                                <option value="">-- pilih kota --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">KURIR</label>
                            <select class="form-control kurir" name="courier" required>
                                <option value="0">-- pilih kurir --</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS</option>
                                <option value="tiki">TIKI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">BERAT (GRAM)</label>
                            <input type="number" class="form-control" name="weight" id="weight" placeholder="Masukkan Berat (GRAM)" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="btnSubmit" class="btn btn-md btn-primary btn-block btn-check">CEK ONGKIR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>                
    </div>    
</div>

<div class="modal" id="modalHasil">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="text-center">Hasil Pencarian</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">            
            <table class="table table-bordered table-judul">
                <tr>
                    <td>Dari</td>
                    <td><span id="asal">Palembang - Sumatera Selatan</span></td>
                </tr>
                <tr>
                    <td>Tujuan</td>
                    <td><span id="tujuan">Banyuasin - Sumatera Selatan</span></td>
                </tr>
                <tr>
                    <td>Berat</td>
                    <td><span id="berat"></span></td>
                </tr>
            </table>    
            <div id="dataHasil">

            </div>                
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        </div>
        
      </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
    axios.interceptors.request.use(function(config) {
      $('.loader').show();
      return config;
    });

    axios.interceptors.response.use(function(response) {
      $('.loader').hide();
      return response;
    });
</script>
<script>

    // $("#modalHasil").modal("show");

    getCity = (provinsiId) => {
        axios.post('/get_city', {   
            provinsiId                             
        })
        .then((res) => {                            
            
            let opt = '<option value="">-- pilih kota --</option>';

            if(res.data.length > 0){

                // tmpUrusan = res.data;                    
                res.data.forEach((data, index) => {

                    opt += `
                        <option value="${data.city_id}">${data.city_name}</option>                    
                    `;
                })
                
                document.getElementById("city_destination").innerHTML = opt;
            }
            

        }, (error) => {
            console.log(error);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {            

        formTampilkan.onsubmit = (e) => {
            
            e.preventDefault();     

            let formData = new FormData(formTampilkan);   

            axios({
                method: 'post',
                url: '/cek_biaya',
                data: formData,                    
            })
            .then(function (res) {
                let dataHasil = '';

                document.getElementById("asal").innerHTML = $( "#city_origin option:selected" ).text()+' - '+$("#province_origin option:selected" ).text();
                document.getElementById("tujuan").innerHTML = $( "#city_destination option:selected" ).text()+' - '+$("#province_destination option:selected" ).text();
                document.getElementById("berat").innerHTML = ($("#weight").val() / 1000 )+' kg';

                res.data[0].costs.forEach((data, index) => {

                    dataHasil += `
                        <table class="table table-bordered table-hasil">
                            <tr>
                                <td>
                                    <h5>${res.data[0].name}</h5>
                                    <small><i>[<strong>${data.service}</strong>] ${data.description}</i></small>
                                </td>
                                <td>
                                    <h4 class="text-right cost">Rp.${data.cost[0].value}</h4>
                                </td>
                            </tr>       
                            <tr>
                                <td>${data.cost[0].etd} Hari</td>    
                            </tr> 
                        </table>
                        
                    `;

                })

                $("#modalHasil").modal("show");
                document.getElementById("dataHasil").innerHTML = dataHasil;
                
                
            })
            .catch(function (response) {
                //handle error
                console.log(response);
            });

        }        
    
    }, false);   
</script>
</body>
</html>