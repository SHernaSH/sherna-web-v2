@extends('layouts.admin')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">

					<h2>Documents</h2>
					<div class="pull-right">
						<form action="{{ route('document.upload') }}" method="post" class="form-horizontal"
							  enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<input type="file" name="file" class="form-control">
							</div>
							<button type="submit" class="btn btn-primary">Upload</button>
						</form>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<table class="table table-striped">
						<thead>
						<tr>
							<th>Document</th>
							<th>
							</th>
						</tr>
						</thead>
						<tbody>
						@foreach($docs as $doc)
							<tr>
								<td>
									<a href="/docs/{{$doc->getRelativePathName()}}" target="_blank"
									   rel="noopener"><u>{{$doc->getFilename()}}</u></a>
								</td>
								<td>
									<a class="btn btn-danger btn-confirm"
									   href="{{ route('document.delete', ['path' => str_replace('/', '*', $doc->getRelativePathName())])}}">Delete</a>
								</td>
							</tr>
						@endforeach

						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>

@endsection
