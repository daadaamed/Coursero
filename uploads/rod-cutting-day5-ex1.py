INT_MIN = -10000
def max(x, y):
  if x > y:
    return x
  return y
def rod_cutting(p, n):
    if n==0 : return 0
    q= INT_MIN
    for i in range(1,n+1):
        print(q,i,p[i],'n-i=',n-i)
        q=max(q,p[i]+rod_cutting(p,n-i))

    return q


if __name__ == '__main__':
  #array starting from 1, element at index 0 is fake
  p = [0,10, 24, 30, 40, 45]
  print(rod_cutting(p, 5))