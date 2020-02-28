trigger OppWonTrigger on Opportunity (after update) {
	for (Opportunity o : Trigger.new) {
		// We often use System.debug to see the values of variables
		System.debug(o);
        System.debug('Opp updated trigger');
        if (httpCallOutCtrl.isFirstTime) {
            httpCallOutCtrl.isFirstTime = false;
            if (o.StageName == 'Won') {
                User oppOwner = [SELECT Id, Email, Name FROM User WHERE Id = :o.OwnerId];
                System.debug('Opp won');
                List<User> supportPeeps = [
                    SELECT Name from User WHERE Id IN 
                    (SELECT UserId FROM OpportunityTeamMember 
                     WHERE OpportunityId = :o.Id) AND Name != :oppOwner.Name
                ];
                
                String supS = '';
                for (User u: supportPeeps) {
                    if (String.isnotBlank(u.Name)){
                    	supS = supS + u.Name + ',';
                    }
                }
                supS = supS.removeEnd(',');
                httpCallOutCtrl.callDuckYeahForOppWon(oppOwner.Name, oppOwner.Email, o.Name, o.Amount, supS);
            }
        }
	}
}