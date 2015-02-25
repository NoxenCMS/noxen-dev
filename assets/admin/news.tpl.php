{% foreach($json->news as $data) %}
    <div class="card-panel white">
        <h4 class="light">{{ $data->title }} <small><?php echo date('d F Y', strtotime($data->created_at)) ?></small></h4>
        <p>{{ $data->content }}</p>
    </div>
{% endforeach %}