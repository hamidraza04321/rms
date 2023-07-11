<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <title>{{ $data['page_title'] }}</title>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Date</th>
              <th>Day</th>
              <th>Subjects</th>
              @foreach($data['exam']->classes as $exam_class)
                <th>{{ $exam_class->class->name }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>10-june</td>
              <td>Tuesday</td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>