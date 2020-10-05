<?php 
 include('header.php');
 include('nav-bar.php');
?>
<!-- ################################################################################################ -->
<div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
  <div class="overlay">
    <div id="breadcrumb" class="clear"> 
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Add</a></li>
        <li><a href="#">List - Remove</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<div class="wrapper row4">
<main class="container clear"> 
    <div class="content"> 
      <div id="comments" >
        <h2>ADD NEW CINE</h2>
        <form action="<?php echo FRONT_ROOT?>Cine/add" method=""  style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Name</th>
                <th>Adress</th>
                <th>Ticket Price</th>
                <th>Capacity</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 300px;">
                  <input type="text" name="name" size="30" required>
                </td>
                <td>
                  <input type="text" name="adress" size="30" required>
                </td>
                <td>
                  <input type="number" min=0 name="ticketPrice" size="10" required>
                </td>     
                <td>
                  <input type="number" min=0 name="capacity" size="10" required>
                </td>         
              </tr>
              </tbody>
          </table>
          <div>
            <input type="submit" class="btn" value="Agregar" style="background-color:#DC8E47;color:white;"/>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>
<!-- ################################################################################################ -->

<?php 
  include('footer.php');
?>