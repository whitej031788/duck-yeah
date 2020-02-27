public class httpCallOutCtrl {    
    @future (callout=true)
    public static void callDuckYeahForOppWon(String user_name, String user_email, String opp_name, Decimal opp_amount) {
		String DUCK_ENDPOINT = 'http://265425e6.ngrok.io/api/salesforce-handler/opp-won';
		// Instantiate a new http object
		Http h = new Http();
 
		// Instantiate a new HTTP request, specify the method (GET) as well as the endpoint
		HttpRequest req = new HttpRequest();
		req.setEndpoint(DUCK_ENDPOINT);
		req.setMethod('POST');
        req.setHeader('Content-Type', 'application/json');
        
        JSONGenerator gen = JSON.createGenerator(true);   
        gen.writeStartObject();     
        gen.writeStringField('user_name', user_name);
        gen.writeStringField('user_email', user_email);
        gen.writeStringField('opp_name', opp_name);
        gen.writeNumberField('opp_amount', opp_amount);
        gen.writeEndObject();   
        String jsonS = gen.getAsString();
        
        req.setbody(jsonS);

		// Send the request, and return a response
		HttpResponse res = h.send(req);
		System.debug('response:--> ' + res.getBody());
 
		// Deserialize the JSON string into collections of primitive data types.
		Map < String,
		Object > resultsMap = (Map < String, Object > ) JSON.deserializeUntyped(res.getBody());
		system.debug('resultsMap-->' + resultsMap);
 
		//return resultsMap;
	}
}