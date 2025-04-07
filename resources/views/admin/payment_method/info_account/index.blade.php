<style>
    #info-account {
        padding: 20px;
        position: relative;
    }
    #form-info-account {
        max-width: 700px;
    }
    #info-bank {
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
    }
    .info-box-1-content {
        text-align: left;
        flex: 1;
        margin-top: 70px;
    }
    .info-box-1-content p strong span {
        color: green;
    }
    .info-box-1-icon-wrapper img,
    .info-box-1-content-wrapper div img {
        width: 100%;
        max-width: 120px;
        height: auto;
    }
    #icon-qr {
        width: 100%;
        max-width: 290px;
        height: auto;
    }
    .info-box-1-note ul p strong,
    .info-box-1-note ul li strong {
        font-size: larger;
    }
    .info-box-1-note ul li span {
        color: green;
    }
    @media (max-width: 768px) {
        .info-box-1-content-wrapper {
            flex-direction: column;
            align-items: center;
        }
        .info-box-1-content,
        .info-box-1-icon-wrapper {
            text-align: center;
            margin-bottom: 20px;
        }
    }
</style>

<div class="row layout-top-spacing">
    <div id="infobox1" class="col-xl-12 col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Danh bạ chuyển tiền</h4>
                    </div>
                </div>
            </div>
            <div id="info-account" class="widget-content widget-content-area">
                <div id="form-info-account" class="info-box-1 color-2">
                    @if ($apiConfig->bankNumber)
                        <div id="info-bank" class="info-box-1-content-wrapper">
                            <div class="info-box-1-content">
                                <p><strong>{{ __('Tên ngân hàng:') }}<span> {{ $apiConfig->bankName }}</span></strong></p>
                                <p><strong>{{ __('Số tài khoản:') }}<span> {{ $apiConfig->bankNumber }}</span></strong></p>
                                <p><strong>{{ __('Tên tài khoản:') }}<span>  {{ $apiConfig->accountName }}</span></strong></p>
                                </div>
                            <div>
                                <img id="icon-qr" class="MuiBox-root css-6jrdpz" alt="icon" src="{{ $apiConfig->qrImageSrc }}">
                            </div>
                        </div>
                    @else
                        <p>Không tìm thấy ngân hàng tương ứng.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>





