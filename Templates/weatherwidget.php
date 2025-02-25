<div class="row d-flex justify-content-center py-5">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card text-body" style="border-radius: 35px;">
            <div class="card-body p-4">
                <div class="d-flex">
                    <h6 class="flex-grow-1"><?php echo $formattedWeather['name']; ?></h6>
                    <h6><?php echo date('H:i', strtotime($formattedWeather['date'])); ?></h6>
                </div>
                <div class="d-flex flex-column text-center mt-5 mb-4">
                    <h6 class="display-4 mb-0 font-weight-bold"><?php echo round($formattedWeather['temp']); ?>°C</h6>
                    <span class="small" style="color: #868B94">Feels like <?php echo round($formattedWeather['feels_like']); ?>°C</span>
                    <span class="small" style="color: #868B94"><?php echo ucfirst($formattedWeather['description']); ?></span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1" style="font-size: 1rem;">
                        <div><i class="bi bi-wind" style="color: #868B94;"></i> <span class="ms-1"><?php echo $formattedWeather['wind']; ?> km/h</span></div>
                        <div><i class="bi bi-droplet" style="color: #868B94;"></i> <span class="ms-1"><?php echo $formattedWeather['humidity']; ?>%</span></div>
                        <div><img src="http://localhost/Twin-cities-web-app/Main/Images/sunrise.png" alt="Sunrise" style="width: 16px; height: 16px;"> <span class="ms-1"><?php echo $formattedWeather['sunrise']; ?></span></div>
                    </div>
                    <div>
                        <img src="https://openweathermap.org/img/wn/<?php echo $formattedWeather['icon']; ?>@2x.png" width="100px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>