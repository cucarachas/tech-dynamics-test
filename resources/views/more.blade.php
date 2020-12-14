
@extends('layouts.app')
@section('title', 'More')

@section('content')
<div class="heading">
    <h1>Welcome</h1>
    <p class="text-muted">Get data from all of UK regions</p>
</div>
<form id="average-form"></form>
<div class="row filters mt-4" style="align-items: flex-end;">
    <div class="col-3 form-group">
        <label for="region" class="control-label">Select a region</label>
        <select form="average-form" name="region" id="region" class="form-control">
            <option value="">Select a region</option>
            <option value="0">All</option>
            <option value="1">North Scotland</option>
            <option value="2">South Scotland</option>
            <option value="3">North West England</option>
            <option value="4">Yorkshire</option>
            <option value="5">North Wales</option>
            <option value="6">South Wales</option>
            <option value="7">West Midlands</option>
            <option value="8">East Midlands</option>
            <option value="9">East England</option>
            <option value="10">South West England</option>
            <option value="11">South England</option>
            <option value="12">London</option>
            <option value="13">South East England</option>
            <option value="14">England</option>
            <option value="15">Scotland</option>
            <option value="16">North West England</option>
            <option value="17">Wales</option>
        </select>
    </div>
</div>

<div class="average mt-4" style="display: none;border:1px solid rgb(220, 220, 220);padding:1rem;">
    <h3>Calculate average for a metric</h3>
    <div class="row average-inner" style="align-items: flex-end;">
        <div class="col form-group metrics">
            <label for="metric" class="control-label">Select metric</label>
        </div>
        <div class="col form-group">
            <label for="date-start" class="control-label">Select start date</label>
            <input form="average-form" type="date" name="date-start" class="form-control">
        </div>
        <div class="col form-group">
            <label for="date-end" class="control-label">Select start date</label>
            <input form="average-form" type="date" name="date-end" class="form-control">
        </div>
        <div class="col form-group">
            <label for="date-end" class="control-label"></label>
            <button class="btn btn-success submit-filters">Submit</button>
        </div>
    </div>
    <p class="average m-0 h4 success"></p>
</div>

<div class="info mt-4"></div>
<script>
    
    $(function(){
        $('#region').change(function(){
            let region = $(this).val();
            let req = {
                url: '{{ route('filtering') }}',
                data: {region},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'post',
                dataType: 'json',
                beforeSend: function(){
                    $('.average').hide();
                    $('#metric').remove();
                },
                success: function(data){
                    $('.info').html('');
                    
                    html = '';
                    data.data.forEach(function(val, key){
                        
                        html += '<h3 class="information-about mt-2">'+val.dnoregion+' / '+val.shortname+'</h3>';
                        
                        html += '<div class="row">';
                        html += '<div class="col-4 com-sm-12">';
                        html += '<h4 class="intensity mt-4">Intensity</h4><ul>';
                        html +=  '<li>forecast - '+val.data[0].intensity.forecast+'</li>';
                        html +=  '<li>index - '+val.data[0].intensity.index+'</li>';
                        html += '</ul>';
                        html += '</div>';

                        if (val.data[0].generationmix.length){
                            html += '<div class="col-4 com-sm-12">';
                            html += '<h4 class="generation-mix mt-4">Generation mix</h4><ul>';
                            
                            metrics = '<select form="average-form" name="metric" id="metric" class="form-control">';
                            metrics += '<option value="0">Select metric</option>';
                            val.data[0].generationmix.forEach(function(val2, key2){
                                html += '<li>'+val2.fuel+' - '+val2.perc+'</li>';
                                metrics += '<option value="'+val2.fuel+'">'+val2.fuel+'</option>';
                            });
                            metrics += '</select>';
                            
                            html += '</ul>';
                            html += '</div>';
                        }

                        $('.metrics').append(metrics);
                        $('.average').show();

                        html += '<div class="col-4 com-sm-12">';
                        html += '<h4 class="period mt-4">Period</h4><ul>';
                        html +=  '<li>from - '+val.data[0].from+'</li>';
                        html +=  '<li>to - '+val.data[0].to+'</li>';
                        html += '</ul>';
                        html += '</div>';

                        html += '</div>';
                    })

                    $('.info').html(html);

                },
                error: function(error){

                }
            }
            $.ajax(req)
        })

        $('button.submit-filters').click(function(){
            var form = {};
            $.each($('#average-form').serializeArray(), function() {
                if (this.value)
                    form[this.name] = this.value;
            });

            let req = {
                url: '{{ route('average') }}',
                data: form,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'post',
                dataType: 'json',
                beforeSend: function(){
                },
                success: function(data){
                    if (data.string){
                        $('p.average').text(data.string);
                    }else{

                    }
                },
                error: function(error){

                }
            }
            $.ajax(req)
        })
    })
</script>
@endsection
