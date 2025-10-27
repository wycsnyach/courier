@extends('layouts.inspinia')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Parcels</h2>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}">Home</a></li>
      <li><a>Parcels</a></li>
      <li class="active"><strong>Edit</strong></li>
    </ol>
  </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="ibox float-e-margins">
    <div class="ibox-title"><h5>Edit Parcel</h5></div>
    <div class="ibox-content">
      {!! Form::model($parcel, ['method' => 'PATCH', 'route' => ['parcels.update', $parcel->id], 'class' => 'form-horizontal']) !!}

        <div class="form-group col-md-12">
          <div class="form-md-line-input col-md-4">
            <label class="control-label">Reference Number</label>
            <input type="text" name="reference_number" class="form-control" value="{{ $parcel->reference_number }}" readonly>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Parcel Type</label>
            <select name="type" class="form-control" required>
              <option value="1" {{ $parcel->type == 1 ? 'selected' : '' }}>Deliver</option>
              <option value="2" {{ $parcel->type == 2 ? 'selected' : '' }}>Pickup</option>
            </select>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Status</label>
            <select name="status" class="form-control">
                <option value="">-- Select Status --</option>
                <option value="0" {{ $parcel->status == 0 ? 'selected' : '' }}>Ordered</option>
                <option value="1" {{ $parcel->status == 1 ? 'selected' : '' }}>Dispatched</option>
                <option value="2" {{ $parcel->status == 2 ? 'selected' : '' }}>Delivered</option>
                <option value="3" {{ $parcel->status == 3 ? 'selected' : '' }}>Received</option>
                <option value="3" {{ $parcel->status == 4 ? 'selected' : '' }}>Returned</option>
            </select>
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="form-md-line-input col-md-4">
            <label class="control-label">Sender Name</label>
            <input type="text" name="sender_name" class="form-control" value="{{ $parcel->sender_name }}" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Sender Address</label>
            <input type="text" name="sender_address" class="form-control" value="{{ $parcel->sender_address }}" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Sender Contact</label>
            <input type="text" name="sender_contact" class="form-control" value="{{ $parcel->sender_contact }}" required>
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="form-md-line-input col-md-4">
            <label class="control-label">Recipient Name</label>
            <input type="text" name="recipient_name" class="form-control" value="{{ $parcel->recipient_name }}" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Recipient Address</label>
            <input type="text" name="recipient_address" class="form-control" value="{{ $parcel->recipient_address }}" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Recipient Contact</label>
            <input type="text" name="recipient_contact" class="form-control" value="{{ $parcel->recipient_contact }}" required>
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="form-md-line-input col-md-4">
            <label class="control-label">From Branch</label>
            <select name="from_branch_id" class="form-control fstdropdown-select" required>
              @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ $branch->id == $parcel->from_branch_id ? 'selected' : '' }}>
                  {{ $branch->branch_code }} - {{ $branch->city }}
                </option>
              @endforeach
            </select>
            <div class="form-control-focus"></div>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">To Branch</label>
            <select name="to_branch_id" class="form-control fstdropdown-select" required>
              @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ $branch->id == $parcel->to_branch_id ? 'selected' : '' }}>
                  {{ $branch->branch_code }} - {{ $branch->city }}
                </option>
              @endforeach
            </select>
            <div class="form-control-focus"></div>
          </div>
           <div class="form-md-line-input col-md-4">
    <label class="control-label">Quantity *</label>
    <input 
      type="number" 
      name="quantity" 
      id="quantity" 
      class="form-control" 
      value="{{ $parcel->quantity }}" 
      required
    >
  </div>

         <!--  <div class="form-md-line-input col-md-4">
            <label class="control-label">Weight (Kg)</label>
            <input type="text" name="weight" class="form-control" value="{{ $parcel->weight }}" required>
          </div> -->
        </div>

        <!-- <div class="form-group col-md-12">
          <div class="form-md-line-input col-md-4">
            <label class="control-label">Height (cm)</label>
            <input type="text" name="height" class="form-control" value="{{ $parcel->height }}" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Width (cm)</label>
            <input type="text" name="width" class="form-control" value="{{ $parcel->width }}" required>
          </div>

          <div class="form-md-line-input col-md-4">
            <label class="control-label">Length (cm)</label>
            <input type="text" name="length" class="form-control" value="{{ $parcel->length }}" required>
          </div>
        </div> -->

        <div class="form-group col-md-12">
  

  <div class="form-md-line-input col-md-4">
    <label class="control-label">Unit Price *</label>
    <input 
      type="number" 
      name="unit_price" 
      id="unit_price" 
      class="form-control" 
      value="{{ $parcel->unit_price }}" 
      step="0.01" 
      required
    >
  </div>

  <div class="form-md-line-input col-md-4">
    <label class="control-label">VAT (16%)</label>
    <input 
      type="text" 
      id="vat_display" 
      class="form-control" 
      value="{{ number_format($parcel->vat, 2) }}" 
      readonly
    >
    <input type="hidden" name="vat" id="vat" value="{{ $parcel->vat }}">
  </div>

  <div class="form-md-line-input col-md-4">
    <label class="control-label">Price</label>
    <input 
      type="text" 
      id="price_display" 
      class="form-control" 
      value="{{ number_format($parcel->price, 2) }}" 
      readonly
    >
    <input type="hidden" name="price" id="price" value="{{ $parcel->price }}">
  </div>
</div>

        <div class="form-group col-md-12">
          

         
          <div class="col-md-8">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Enter parcel description...">{{ old('description', $parcel->description ?? '') }}</textarea>
          </div>
           <div class="form-md-line-input col-md-4">
            <label class="control-label">Status</label>
            <input type="number" name="status" class="form-control" value="{{ $parcel->status }}" step="0.01" required>
          </div>
        </div>

        <div class="hr-line-dashed"></div>
        <div class="form-group">
          <div class="col-sm-6 col-sm-offset-2">
            <a href="{{ route('parcels.index') }}" class="btn btn-white">Cancel</a>
            <button class="btn btn-primary" type="submit">Update</button>
            <a href="{{ route('parcels.index') }}"><button class="btn btn-danger" type="button">Back</button></a>
          </div>
        </div>

      {!! Form::close() !!}
    </div>
  </div>
</div>

<!-- Auto Calculation Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const quantityInput = document.getElementById('quantity');
  const unitPriceInput = document.getElementById('unit_price');
  const vatDisplay = document.getElementById('vat_display');
  const vatHidden = document.getElementById('vat');
  const priceDisplay = document.getElementById('price_display');
  const priceHidden = document.getElementById('price');

  function formatNumber(num) {
    return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  function calculateValues() {
    const quantity = parseFloat(quantityInput.value) || 0;
    const unitPrice = parseFloat(unitPriceInput.value) || 0;
    const subtotal = quantity * unitPrice;
    const vat = 0.16 * subtotal;
    const total = subtotal + vat;

    // Display formatted numbers
    vatDisplay.value = formatNumber(vat);
    priceDisplay.value = formatNumber(total);

    // Save raw numeric values
    vatHidden.value = vat.toFixed(2);
    priceHidden.value = total.toFixed(2);
  }

  // Trigger calculation on input, blur, and page load
  quantityInput.addEventListener('input', calculateValues);
  unitPriceInput.addEventListener('input', calculateValues);
  quantityInput.addEventListener('blur', calculateValues);
  unitPriceInput.addEventListener('blur', calculateValues);

  // Run once when page loads (for edit form)
  calculateValues();
});
</script>
@endsection
