<div class="registrationPage">
	<div class="profile_setup">
		<form id="leagueRegisterForm" name="form1" action="create_league_profile.php">
			<table id="leagues_registration_table">
				<tr>
					<td><label for="username">Username:</label></td>
					<td><input type="text" id="username" name="username" autofocus></td>
				</tr>
			
				<tr>
					<td><label for="password1">Password:</label></td>
					<td><input type="password" id="password1" name="password1"></td>
				</tr>
			
				<tr>
					<td><label for="password2">Confirm Password:</label></td>
					<td><input type="password" id="password2" name="password2"></td>
				</tr>

				<tr>
					<td><label for="league_name">League Name:</label></td>
					<td><input type="text" id="leagues_name" name="leagues_name"></td>
				</tr>
			
				<tr>
					<td><label for="commish">League Commissioner:</label></td>
					<td><input type="text" id="leagues_commish" name="leagues_commish"></td>
				</tr>	
			
				<tr>
					<td><label for="league_address">League Address:</label></td>
					<td><input type="text" id="leagues_address" name="leagues_address"></td>
				</tr>
				
				<tr>
					<td><label for="email">Email:</label></td>
					<td><input type="text" id="leagues_email" name="leagues_email"></td>
				</tr>
				
				<tr>
					<td><label for="phone">Phone Number:</label></td>
					<td><input type="text" id="leagues_phone" name="leagues_phone"></td>
				</tr>
				
				<tr>
					<td><label for="leagues_comp">Competition Level:</label></td>
					<td><select size="2" id="leagues_comp" name="leagues_comp[]" multiple>
						<option name="comp_level" value="co_ed" selected>Co-Ed</option>
						<option name="comp_level" value="recreational">Recreational</option>
						<option name="comp_level" value="intermediate">Intermediate</option>							
						<option name="comp_level" value="competitive">Competitive</option>
					</select></td>
				</tr>	
				
				<tr>
					<td><label for="leagues_age">Competition Age Level:</label></td>
					<td><select size="2" id="leagues_age" name="leagues_age[]"  multiple>
						<option name="comp_age" value="10_and_under" selected>10 and under</option>
						<option name="comp_age" value="12_and_under">12 and under</option>
						<option name="comp_age" value="14_and_under">14 and under</option>							
						<option name="comp_age" value="16_and_under">16 and under</option>
						<option name="comp_age" value="18_and_under">18 and under</option>
						<option name="comp_age" value="unlimited">No Age Limit</option>
						<option name="comp_age" value="30_and_over">30 and over</option>
						<option name="comp_age" value="50_and_over">50 and over</option>
					</select></td>
				</tr>		

				<tr>
					<td><label for="leagues_fee">League Entry Fee:</label></td>
					<td><input type="number" id="leagues_fee" name="leagues_fee" min="0"></td>
				</tr>					
				
				<tr>
					<td><label for="ref_fee">Referee Fee/Game:</label></td>
					<td><input type="number" id="ref_fee" name="ref_fee" min="0"></td>
				</tr>					
				
				<tr>
					<td><label for="website">Website:</label></td>
					<td><input type="text" id="leagues_website" name="leagues_website"></td>
				</tr>
			</table>
			
			<input type="submit" name="submit" id="regLeague_btn" value="Register My League">	
		</form>
	</div>
</div>	
	