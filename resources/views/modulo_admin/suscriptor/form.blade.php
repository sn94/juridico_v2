<div class="input-group">
                            <input  value="{{isset($dato)?$dato->RAZON_SOCIAL: ''}}" maxlength="80" class="input--style-1" type="text" placeholder="Nombre completo o razón social" name="RAZON_SOCIAL">
						</div>
						<div class="input-group">
                            <input value="{{isset($dato)?$dato->EMAIL: ''}}"  maxlength="60" class="input--style-1" type="text" placeholder="E-mail" name="EMAIL">
                        </div>
						
						
						<div class="input-group">
                            <input value="{{isset($dato)?$dato->TELEFONO: ''}}" oninput="phone_input(event)" maxlength="20" class="input--style-1" type="text" placeholder="Teléfono" name="TELEFONO">
						</div>
						<div class="input-group">
                            <input value="{{isset($dato)?$dato->CELULAR: ''}}" oninput="phone_input(event)" maxlength="20" class="input--style-1" type="text" placeholder="Celular" name="CELULAR">
                        </div>
                        

                        @if( !isset( $ocultar_btn_ver_plan) )
						<div class="input-group" id="verplanes">
						<a  style="padding: 4px 8px; color: lightblue; border-radius: 25px; background-color: black; font-weight: 600;  text-decoration: none ; font-size: 16px;" href="#" onclick="mostrarPlanes()">Ver planes</a>
                        </div>
                        @endif

                        <div class="input-group">
							
                            <div class="rs-select2 js-select-simple select--no-search">
                                <select name="PLAN" >

                                    @foreach( $planes as $plan )
                                    @if(isset($dato) &&  $dato->PLAN == $plan->IDNRO)
                                    <option selected value="{{$plan->IDNRO}}"> {{  $plan->DESCR}} </option> 
                                    @else 
                                    <option value="{{$plan->IDNRO}}"> {{  $plan->DESCR}} </option> 
                                    @endif
									@endforeach

                                </select>
                                <div class="select-dropdown"></div>
                            </div>
                        </div>
                       
                        <div class="p-t-20">
                            <button id="btnGUARDAR" class="btn btn--radius btn--green" type="submit">Aceptar</button>
                        </div>