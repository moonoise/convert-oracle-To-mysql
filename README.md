"# convert-oracle-To-mysql" 
<h2>การ backup ข้อมูล จากฐาน oracle มาเป็น mysql กรณีที่มีข้อมูลมากๆ </h2>
<p>อันนี้เป็นตัวอย่างจากงานจริงที่ผมทำนะครับ เผื่อใครจะเอาไปดัดแปลง ใช้กับงานตัวเอง</p>
<p>Oracle ใช้ OCI8 library  ในการเชื่อมต่อ</p>
<p>ผมทำการ <b>Query</b> ข้อมูล  แล้วเก็บไว้เป็นไฟล์ .csv โดยเป็นเป็น ไฟล์ละไม่เกิน 1000 record </p> 
<p>เนื่องจากว่า ผมลอง fetch ข้อมูลแล้ว query เก็บลง mysql ทัน  มันไม่สามารถ Query ทัน  </>
<p>เลยใช้คำสั่ง  LOAD DATA LOCAL INFILE ของ sql มาช่วยแทนแต่ก็ต้องแบ่งข้อมูล แล้วค่อยทย่อยquery ทีละ 1000 record เหมือนดิม  </p>
<p> หลังจาก LOAD DATA เสร็จ ก็ให้โปรแกรมทำงาน ลบ ไฟล์ csv ออก </p>

<p>ถ้าทำจะไว้ตั้งระบบให้ทำการ backup ข้อมูลทุกๆ วัน ก็สามารถทำได้  โดยการ เขียน script ให้รันไฟล์ php  ตัวอย่างนี้ผมรันใน xxampp บน windows  </p>
<code>$ php -f my_script.php</code>
<p>เนื่องจากโค๊ดนี้ ใช้ OCI Driver ในการ connect Oracle ทำให้ไม่สามารถใช้คำสั่งนี้ได้ ผมจึงเปลี่ยนมาใช้คำสั่ง  </p>
<code>cmd /c start URL:// </code> 
<p>แทน และใช้คำสั่ง ในการปิด browser </p>
<code>TSKILL chrome</code> 

<p> แล้วไปใส่ไว้ใน <b>Task Scheduler</b> ของ windows </p>


