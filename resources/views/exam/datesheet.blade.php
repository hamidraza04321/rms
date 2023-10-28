<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <title>{{ $data['page_title'] }}</title>

  <style type="text/css">
    body {
      font-family: sans-serif;
    }
    .logo {
      width: 175px;
      height: 175px;
      position: relative;
      border-radius: 100%;
      border: 6px solid #f8f8f8;
      box-shadow: 0 2px 4px 0 rgba(0,0,0,.1);
      margin-right: 5%;
    }
    .m-15 {
      margin: 15px 0px;
    }
    .school-name {
      margin-top: 35px;
      text-transform: uppercase;
      letter-spacing: 5px;
    }
    table {
      font-size: 14px;
    }
    table thead tr th, table tbody tr td {
      padding: 7px !important;
      vertical-align: middle !important;
    }
    table tbody tr td {
      line-height: 25px;
    }
    .no-wrap {
      white-space: nowrap;
    }
    @media print {
      @page {
        size: landscape;
      }
    }
  </style>
</head>
<body onload="window.print()">
  <div class="container-fluid">
    <div class="row m-15 justify-content-center">
      <img src="{{ url($settings->school_logo) }}" class="logo" width="150px">
      <div class="text-center">
        <h2 class="school-name">{{ $settings->school_name }}</h2>
        <h4>{{ $data['datesheet']->exam->name }} ( {{ $data['datesheet']->exam->session->name }} )</h4>
      </div>
    </div>
    <div class="row">
      <table class="table table-bordered table-hover no-wrap">
        <thead>
          <tr>
            <th>Date</th>
            <th>Day</th>
            <th>Time</th>
            @foreach($data['datesheet']->classes as $class)
              <th class="text-center">{{ $class->name }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach($data['datesheet']->exam_schedules as $exam_schedule)
            @foreach($exam_schedule->timings as $time => $classes)
              <tr>
                @if($loop->first)
                  <td rowspan="{{ $exam_schedule->timings_count }}">{{ date($settings->date_format, strtotime($exam_schedule->date)) }}</td>
                  <td rowspan="{{ $exam_schedule->timings_count }}">{{ date('l', strtotime($exam_schedule->date)) }}</td>
                @endif
                <td>{{ $time }}</td>
                @foreach($classes as $subjects)
                  <td class="text-center">
                    {!! (!empty($subjects)) ? implode('<br>', $subjects) : '--' !!}
                  </td>
                @endforeach
              </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
    <p style="page-break-after: always;"></p>
    <div class="row m-15 justify-content-center">
      <img src="{{ url($settings->school_logo) }}" class="logo" width="150px">
      <div class="text-center">
        <h2 class="school-name">{{ $settings->school_name }}</h2>
        <h4>{{ $data['datesheet']->exam->name }} ( {{ $data['datesheet']->exam->session->name }} )</h4>
      </div>
    </div>
    <div class="row">
      <table class="table table-bordered table-hover no-wrap">
        <thead>
          <tr>
            <th rowspan="2">Date</th>
            <th rowspan="2">Day</th>
            <th rowspan="2">Time</th>
            @foreach($data['datesheet']->group_classes as $class_name => $class_groups)
              <th class="text-center" colspan="{{ count($class_groups) }}">{{ $class_name }}</th>
            @endforeach
          </tr>
          <tr>
            @foreach($data['datesheet']->group_classes as $class_name => $class_groups)
              @foreach($class_groups as $class_group)
                <th class="text-center">{{ $class_group->group->name }}</th>
              @endforeach
            @endforeach
          </tr>
          <tbody>
            @foreach($data['datesheet']->exam_schedules_group as $exam_schedule_group)
              @foreach($exam_schedule_group->timings as $time => $classes)
                <tr>
                  @if($loop->first)
                    <td rowspan="{{ $exam_schedule_group->timings_count }}">{{ date($settings->date_format, strtotime($exam_schedule_group->date)) }}</td>
                    <td rowspan="{{ $exam_schedule_group->timings_count }}">{{ date('l', strtotime($exam_schedule_group->date)) }}</td>
                  @endif
                  <td>{{ $time }}</td>
                  @foreach($classes as $groups)
                    @foreach($groups as $subjects)
                      <td class="text-center">
                        {!! (!empty($subjects)) ? implode('<br>', $subjects) : '--' !!}
                      </td>
                    @endforeach
                  @endforeach
                </tr>
              @endforeach
            @endforeach
          </tbody>
        </thead>
        <tbody>
          
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>