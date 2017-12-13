<footer >
    <div class="container-fluid"  style="background: #000000;" >
        <p class="footer">
            <a class="lnk-clk" href="{{ url('/pages/about-us') }}">About Us </a>
            | 
            <a class="lnk-clk" href="{{ url('/pages/community-rules') }}">Community Rules</a>
            |
            <a class="lnk-clk" href="{{ url('/pages/faqs') }}">FAQs  </a>

            | 
            <a class="lnk-clk" href="{{ url('new-signup') }}">Join Us </a>
        </p>

        <div class="height5"></div>
        <p class="text-center">
        <div class="reseve-word">
            2017 © <a href='{{ url('/') }}' style="color: #fff;"> {{ $config_data->website_title }} </a>, LCC. All Rights Reserved
        </div>
        </p>
        <div class="height5"></div>
    </div>
</footer>