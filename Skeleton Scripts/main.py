import requests, sys, re
from bs4 import BeautifulSoup

session = requests.Session()

def exploit_rce():
    print ("(+) RCE: Reverse shell spawned....")

def auth_bypass(target_ip):
    """
    url = 'http://%s/path' % target_ip
    body = {'parameter1': 'value1',
             'parameter2': 'value2'
            }

    session.get(target) #GET Request
    session.post(url, data = body) #POST Request

    #Parse response based on string match, check Skeleton Function/parse_response for more examples
    s = BeautifulSoup(r.text, 'lxml')
    authenticated_string = re.search("Welcome to dashboard", s.text)
    if authenticated_string:
        return "Authenticated"
    return "Unable to authenticate"
    """

def main():
    if len(sys.argv) != 4:
        print ("(+) usage: %s <target ip> <nc ip> <nc port>"  % sys.argv[0])
        print ('(+) eg: %s 192.168.121.103'  % sys.argv[0])
        sys.exit(-1)

    print ("(+) Auth Bypass: Exploiting XYZ vulnerability....")
    auth_bypass(sys.argv[1])
    
    print ("(+) RCE: Exploiting XYZ vulnerability....")
    exploit_rce()

if __name__ == "__main__":
    main()
