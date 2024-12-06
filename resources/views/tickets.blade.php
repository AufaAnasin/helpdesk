@extends('layouts.app', ['pageSlug' => 'tickets'])

@section('content')
<div class="container-fluid">
    <div class="row" style="display: flex; flex-direction: row;">
        {{-- for ongoing tickets --}}
        <div class="col-12">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">Ongoing Tickets 🚠</h4>
                    <p class="card-category">These tickets are currently being addressed by our support team and are in progress.</p>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive"> <!-- Added table-responsive class -->
                      <table class="table w-100"> <!-- Added w-100 for full width -->
                        <thead class="text-primary">
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Salary</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Dakota Rice</td>
                            <td>Niger</td>
                            <td>Oud-Turnhout</td>
                            <td class="text-primary">$36,738</td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Minerva Hooper</td>
                            <td>Curaçao</td>
                            <td>Sinaai-Waas</td>
                            <td class="text-primary">$23,789</td>
                          </tr>
                          <tr>
                            <td>3</td>
                            <td>Sage Rodriguez</td>
                            <td>Netherlands</td>
                            <td>Baileux</td>
                            <td class="text-primary">$56,142</td>
                          </tr>
                          <tr>
                            <td>4</td>
                            <td>Philip Chaney</td>
                            <td>Korea, South</td>
                            <td>Overland Park</td>
                            <td class="text-primary">$38,735</td>
                          </tr>
                          <tr>
                            <td>5</td>
                            <td>Doris Greene</td>
                            <td>Malawi</td>
                            <td>Feldkirchen in Kärnten</td>
                            <td class="text-primary">$63,542</td>
                          </tr>
                          <tr>
                            <td>6</td>
                            <td>Mason Porter</td>
                            <td>Chile</td>
                            <td>Gloucester</td>
                            <td class="text-primary">$78,615</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
        </div>

        {{-- for finished tickets --}}
    </div>
</div>
@endsection
