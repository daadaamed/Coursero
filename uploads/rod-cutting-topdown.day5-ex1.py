INT_MIN = -10000
memo=[0 for i in range (10)]
print(memo)
def max(x, y):
  if x > y:
    return x
  return y
def rod_cutting(p, n,memo):
    if memo[n] >0:
        return memo[n]
    elif n==0 : 
        return 0
    q= INT_MIN
    for i in range(1,n+1):
        print(q,i,p[i],'n-i=',n-i)
        q=max(q,p[i]+rod_cutting(p,n-i,memo))
        print('n-i=',n-i,'   ', n,i)
    memo[n]=q
    return memo[n]


if __name__ == '__main__':
  #array starting from 1, element at index 0 is fake
  p = [0,3,5,10,12,14]
  print(rod_cutting(p, 5,memo))