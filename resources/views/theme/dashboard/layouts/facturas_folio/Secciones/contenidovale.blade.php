@switch(count($getFoliosDisponibles))
    @case(1)
        @foreach ($getFoliosDisponibles as $k => $v)
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    {!! Form::label('denominacion_vales', 'DENOMINACIÓN:') !!}
                    <div class="custom-file">
                        {!! Form::text('denominacion_vales[]', $v['denominacion'], ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'denominacion_vales[{{ $k }}]', 'readonly']) !!}
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    {!! Form::label('vales_de', 'De:') !!}
                    <div class="custom-file">
                        {!! Form::text('vales_de', $v['folios'], ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'vales_de']) !!}
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    {!! Form::label('vales_hasta', 'Hasta:') !!}
                    <div class="custom-file">
                        {!! Form::text('vales_hasta','' , ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'vales_hasta']) !!}
                    </div>
                </div>
            </div>
        @endforeach
        @break
    @case(2)
        @foreach ($getFoliosDisponibles as $item => $value)
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    {!! Form::label('denominacion_vales', 'DENOMINACIÓN:') !!}
                    <div class="custom-file">
                        {!! Form::text('denominacion_vales[{{ $item + 1  }}]', $value['denominacion'], ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'denominacion_vales[{{ $item + 1 }}]', 'readonly']) !!}
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    {!! Form::label('vales_de', 'De:') !!}
                    <div class="custom-file">
                        {!! Form::text('vales_de[{{ $item + 1 }}]', $value['folios'], ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'vales_de[{{ $item + 1 }}]']) !!}
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    {!! Form::label('vales_hasta', 'Hasta:') !!}
                    <div class="custom-file">
                        {!! Form::text('vales_hasta[{{ $item + 1  }}]', '', ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'vales_hasta']) !!}
                    </div>
                </div>
            </div>
        @endforeach
        @break
    @default

@endswitch
