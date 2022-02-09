import subprocess

def run_system_command():
    result = subprocess.run(['ls', '-l'], stdout=subprocess.PIPE)
    command_output = result.stdout.decode('utf-8')
    return command_output

print(run_system_command())