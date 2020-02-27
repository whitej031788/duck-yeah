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
                httpCallOutCtrl.callDuckYeahForOppWon(oppOwner.Name, oppOwner.Email, o.Name, o.Amount);
            }
        }
	}
}