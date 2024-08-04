<div class="form-group row justify-content-center">
    <div style="position:relative" class="d-flex justify-content-center">
        <div class="template-agent-name " style="margin-top: 380px;font-size: 22px;font-weight: 600;">

            {{ $sale->name_th }}
            
        </div>
        <br>
        <div class="template-agent-text"
            style="margin-top: 435px;font-size: 20px;font-weight: 400; text-transform: uppercase;">
            <span>{{ $sale->role($sale->id)->name }}</span>
        </div>
        <div class="template-agent-text" style="margin-top: 465px;font-size: 20px;font-weight: 400;">
            <span>Distribution Department</span>
        </div>
        <div class="template-agent-text" style="margin-top: 495px;font-size: 20px;font-weight: 400;">
            <span>ID Code : {{ $sale->code }}</span>
        </div>
        <div class="template-date-text" style="margin-top: 550px;margin-left: -180px;font-size: 14px;font-weight: 400;">
            <span>Date of Issue : {{ date('d/m/y', strtotime($sale->created_date)) }} </span>

        </div>
        <div class="template-date-text"
            style="margin-top: 550px;margin-right: -180px;font-size: 14px;font-weight: 400;">
            <span>Date of Expiry :
                @php

                    $createdDate = new DateTime($sale->created_date);
                    $createdDate->modify('+1 year');
                    $createdDate->modify('-1 day');
                    $Expiry = $createdDate->format('d/m/y');

                @endphp
                {{ $Expiry }}
            </span>

        </div>
        {{-- <div class="template-agent-text" style="margin-top: 520px;font-size: 20px;font-weight: 400;">
            <span>{{$sale->code}}</span>
        </div> --}}
        @if ($sale->img_user)
            <img src="{{ $sale->img_user }}" alt="" id="image_profile_preview"
                style="position:absolute;margin-top:109px;border-radius: 50%;border:12px solid #000;" width="250px"
                height="250px;">
        @else
            <img src="/images/user.jpg" alt="" id="image_profile_preview"
                style="position:absolute;margin-top:109px;border-radius: 50%;border:12px solid #000;" width="250px"
                height="250px;">
        @endif
        <img src="/images/TemplateAgent2024.png" id="template-agent" alt="" style="max-height:600px;z-index:2;"
            class="shadow-sm cursor-pointer">
        <input type="file" style="opacity: 0;position:absolute" name="image_profile" id="image_profile">
    </div>
</div>
