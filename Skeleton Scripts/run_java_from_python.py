import requests, sys, subprocess

session = requests.Session()

def run_java_program(value):
    content_java_program = """
    public class Hello {
        public static void main(String[] args) {
            //java Hello <value>
            String value = args[0];
            System.out.println("The value is: "+value);
        }
    }
    """
    f = open("Hello.java", "w")
    f.write(content_java_program)
    f.close()

    #Compile Java program  
    subprocess.run(['javac', 'Hello.java'], stdout=subprocess.PIPE)

    #Run Java program and return the manipulated cookie
    return subprocess.run(['java', 'Hello', value], stdout=subprocess.PIPE).stdout.decode('utf-8')

def main():
    if len(sys.argv) != 2:
        print ("(+) usage: %s <value>"  % sys.argv[0])
        print ('(+) eg: %s 123'  % sys.argv[0])
        sys.exit(-1)

    print(run_java_program(sys.argv[1]).replace("\n",""))

if __name__ == "__main__":
    main()