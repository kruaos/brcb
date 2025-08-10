<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>บันทึกข้อมูลเงินกู้</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
  <h2>ฟอร์มบันทึกข้อมูลเงินกู้</h2>
  <form action="insert.php" method="post">
    <div class="form-group">
      <label>RefNo:</label>
      <input type="text" name="RefNo" class="form-control" required>
    </div>
    <div class="form-group">
      <label>IDMember (รหัสสมาชิก):</label>
      <input type="number" name="IDMember" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Amount (จำนวนเงิน):</label>
      <input type="number" name="Amount" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Instalment (งวด):</label>
      <input type="number" name="Instalment" class="form-control" required>
    </div>
    <div class="form-group">
      <label>InterestRate (ดอกเบี้ย %):</label>
      <input type="number" name="InterestRate" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Insurer1:</label>
      <input type="text" name="Insurer1" class="form-control">
    </div>
    <div class="form-group">
      <label>Insurer2:</label>
      <input type="text" name="Insurer2" class="form-control">
    </div>
    <div class="form-group">
      <label>IDReason (เหตุผล):</label>
      <input type="text" name="IDReason" class="form-control" value="1">
    </div>
    <div class="form-group">
      <label>DocNo (เลขที่เอกสาร):</label>
      <input type="text" name="DocNo" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">บันทึก</button>
  </form>
</div>
</body>
</html>
